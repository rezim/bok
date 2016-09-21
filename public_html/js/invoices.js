

InvoiceManager = function(api_token, endpoint, company_name, invoice_number_length) {
    var invoicesUrl = [endpoint, 'invoices.json'].join('/');
    var invoiceViewUrl = [endpoint, 'invoice'].join('/');

    var clientsUrl = [endpoint, 'clients.json'].join('/');

    var self = this;

    var currentPeriodInvoices = {
        period: null,
        invoices: [],
        orderedInvoices: []
    };

    var status = {
        issued: "wystawiona",
        sent: "wysłana",
        paid: "opłacona",
        partial: "częściowo opłacona",
        rejected: "odrzucona"
    };

    var getStatus = function(invStatus, sentTime) {
        var result = invStatus;
        if (result == 'wystawiona' && sentTime) {
            result = 'wysłana';
        }

        return result;
    };

    /**
     * tmp function to synch clients, need to be refactored
     * @deprecated
     */
    var updateClients = function() {
        $.when(getClients(['page=1']), getClients(['page=2'])).done(function(client1, client2) {
            var clients = client1[0].concat(client2[0]);

            var text = "START TRANSACTION;\n";
            $.each(clients, function (idx, client) {
                var updateCmd = "update clients set nazwapelna='" + client.name.split('"').join('') + "', nazwakrotka='" + client.shortcut.split('"').join('') + "', ulica = '" + client.street + "', kodpocztowy='" + client.post_code + "', mailfaktury = '" + client.email + "', miasto = '" + client.city + "' where nip='" + client.tax_no + "';";

                text += updateCmd + "\n";
            });

            text += "Commit;";
            $("textarea#clients").val(text);
        });
    };

    this.getInvoices = function() {
        return currentPeriodInvoices.invoices;
    };

    this.getMissingInvoices = function() {
        return currentPeriodInvoices.missingInvoices;
    };

    this.showInvoice = function(token, title) {
        var url = [invoiceViewUrl, token].join('/');
        window.open(url, title);
    };

    this.getLastInvoice = function() {
        var invoices = this.getInvoices();
        var last;
        invoices.forEach(function(invoice) {
            if (!last) {
                last = invoice;
            } else {
                if (parseInt(invoice.number.split('/')[0]) > parseInt(last.number.split('/')[0])) {
                    last = invoice;
                }
            }
        });

        return last;
    };

    this.updateInvoiceNumber = function(id, number, callback) {
        var url = [endpoint, 'invoices', id + '.json'].join('/');

        var data = {"invoice": {
            "number": number}};

        put(url, data, callback);
    };

    this.getInvoiceById = function(id) {
        var invoices = this.getInvoices();

        return invoices.find(function(val) {
            return val.id == id
        })
    };

    this.removeInvoice = function(id, rowSelector, status) {

        if (status == 'wystawiona') {

            var url = [endpoint, 'invoices', [id, 'json'].join('.')].join('/');

            if (confirm('Czy na pewno chcesz usunąć fakturę?')) {
                // var lastInvoice = self.getLastInvoice();
                // var removedInvoice = self.getInvoiceById(id);
                del(url, function (inv) {

                    self.refreshInvoices();
                    $(rowSelector).remove();

                });
            }
        } else {
            alert('Nie moża usunąć faktury, której status jest "' + status + '"!');
        }
    };

    this.add = function (invoice, agreementIds) {
        if (agreementIds && agreementIds.length > 0) {

            if (invoice['fakturadlakazdejumowy'] && agreementIds.length > 1) {
                var calls = [];

                var id = agreementIds.splice(0,1);
                var params = getInvoiceParams(invoice, id);

                post(params, function () {
                    self.refreshInvoices(null, function() {
                        self.add(invoice, agreementIds);
                    });
                });
            } else {
                var params = getInvoiceParams(invoice, agreementIds);

                post(params, function (data) {
                    self.refreshInvoices();
                });
            }
        } else {
            alert("Wybierz przynajmniej jedną umowę!");
        }
    };

    /**
     *
     * @param clientSelector
     * @param agreementSelector
     * @returns {Array}
     */
    this.getSelectedAgreementIds = function(clientSelector, agreementSelector) {
        var selectedAgreementIds = [];
        $([clientSelector, agreementSelector].join(" ")).map(function() {
            selectedAgreementIds.push($(this).val());
        });

        return selectedAgreementIds;
    };

    /**
     * @type {{dateFrom: *, dateTo: *}} period
     */
    this.refreshInvoices = function (period, callback) {
        if (period) {
            currentPeriodInvoices.period = period;
        }

        if (currentPeriodInvoices.period) {
            var params = [];
            params.push("period=more");
            params.push(["date_from", currentPeriodInvoices.period.dateFrom].join('='));
            params.push(["date_to", currentPeriodInvoices.period.dateTo].join('='));

            var params1 = params.concat([["page", 1].join('=')]);
            var params2 = params.concat([["page", 2].join('=')]);

            $('.invoice-add').hide();
            $('.invoice-loading').show();

            $.when(get(params1), get(params2)).done(function(inv1, inv2) {

                $('.invoice-add').show();
                $('.invoice-loading').hide();

                var invoices = [] ;

                // remove all invoice corrects (from_invoice_id != null)
                $.each(inv1[0].concat(inv2[0]), function (index, inv) {
                    if (!inv['from_invoice_id']) {
                        invoices.push(inv);
                    }
                });

                currentPeriodInvoices.invoices = invoices;

                var orderedInvoices = Array.apply(null, Array(invoices.length)).map(function () {});

                // groupByClient
                var groupedInvoices = {};

                var invNbPattern = null;

                $.each(invoices, function (index, invoice) {
                    if (!groupedInvoices[invoice['buyer_tax_no']]) {
                        groupedInvoices[invoice['buyer_tax_no']] = [];
                    }

                    groupedInvoices[invoice['buyer_tax_no']].push(invoice);

                    var invoiceIdx = parseInt(invoice.number.split('/')[0])-1;
                    orderedInvoices[invoiceIdx] = invoice;

                    if (!invNbPattern) {
                        invNbPattern = invoice.number.split('/');
                        invNbPattern.shift();
                        invNbPattern = invNbPattern.join('/');
                    }
                });

                var missingInvoices = [];

                $.each(orderedInvoices, function (index, invoice) {
                    if (invoice === undefined) {
                        missingInvoices.push([(index+1),'/',invNbPattern].join(''));
                    }
                });

                currentPeriodInvoices.missingInvoices = missingInvoices;

                // reset all invoice counts
                $('.invoice-count').text('0').css({'color':'red'});


                // set initial state for all agreements, visible and selected
                $('.to_invoice_agreement').prop('checked', true).show();

                // set new invoice counts
                $.each(groupedInvoices, function (key, group) {

                    $('.invoice-count.' + key).text(group.length).unbind('click');

                    $('.invoice-count.' + key).text(group.length).bind('click', function() {
                        createInvoiceListView(key, group);
                    });

                    var allAgrCount = 0;
                    var selector = [];
                    var selectorPrefix = ['.agreements-list',key].join('.');

                    group.forEach(function(invoice) {
                        var agreements = (invoice.internal_note) ? invoice.internal_note.split(',') : [];
                        if (agreements.length > 0) {
                            agreements.forEach(function(agreement) {
                                // split().join() instead of replace all which is not defined :/
                                selector.push([selectorPrefix, ['.',agreement.split('/').join('-')].join(''), '.to_invoice_agreement'].join(' '));
                            });
                        }
                        allAgrCount += agreements.length;
                    });
                    // uncheck and hide all agreements already on invoice
                    $(selector.join(',')).prop('checked', false).hide();

                    if ($([selectorPrefix,".to_invoice_agreement"].join(' ')).length != allAgrCount) {
                        $('.invoice-count.' + key).css({'color':'red', 'font-weight': 'bold'});
                    } else {
                        $('.invoice-count.' + key).css({'color':'green', 'font-weight': 'bold'});
                    }
                });


                if (self.getMissingInvoices().length > 0) {

                    $('.errorMessageWrapper').show();
                    $('#errorMessage').html('Uwaga: występuje brak ciągłości numeracji faktur. Brakujące numery to: ' + self.getMissingInvoices().join(', '));

                } else {

                    $('#errorMessage').html('');
                    $('.errorMessageWrapper').hide();

                }
                if (callback) {
                    callback();
                }
            });




        } else {
            console.log('could not get invoices, no period defined');
        }
    };

    /**
     * @type {{dateFrom: *, dateTo: *}} period
     */
    this.showAgreementWarnings = function(period) {
        var today = new Date();
        today = new Date(dateFormat(today));
        var dateTo = new Date(dateFormat(period.dateTo));

        if (dateTo <= today) {

            $('.agreements-list').each(function (idx, list) {

                var anyWarning = false;
                $(list).find('.agreement-nb').each(function (index, agreement) {
                    var blackenddate = $(agreement).attr('blackenddate');
                    var colorenddate = $(agreement).attr('colorenddate');

                    var blackEnd = $(agreement).attr('blackend');
                    var colorEnd = $(agreement).attr('colorend');

                    if (blackenddate && blackenddate != '0000-00-00') {
                        if (blackenddate.split(' ')[0] != dateFormat(period.dateTo)) {
                            $(agreement).find('.fa.fa-exclamation-triangle').show();
                            anyWarning = true;
                        }
                    }

                    if (colorenddate && colorenddate != '0000-00-00' && parseInt(colorEnd) > 0) {
                        if (colorenddate.split(' ')[0] != dateFormat(period.dateTo)) {
                            $(agreement).find('.fa.fa-exclamation-triangle').show();
                            anyWarning = true;
                        }
                    }

                });

                if (anyWarning) {
                    $('.' + $(list).attr('id')).find('.fa.fa-exclamation-triangle').show();
                }
            });
        }
    };

    var createInvoiceListView = function(key, group) {

        var table$ = $('<table />').attr('class', 'tablesorter displaytable');

        var head$ = $('<thead />');

        [{'name': 'Lp', 'width': '20px'}, {'name': 'Numer', 'width': '35px'}, {'name': 'Nazwa klienta', 'width': '220px'}, {'name': 'Umowy', 'width': '150px'}, {'name': 'Cena netto', 'width': '100px'}, {'name': 'Wartość VAT', 'width': '100px'}, {'name': 'Wartość brutto', 'width': '100px'}, {'name':'Status', 'width': '100px'}, {'name':'', 'width': '100px'}].forEach(function(th) {
            head$.append($('<th>').attr('style', ['width', th['width']].join(':')).html(th['name']));
        });

        table$.append(head$);

        var body$ = $('<tbody />');

        for(var i=0; i < group.length; i++) {
            row$ = $('<tr/>').attr('id', ['row', group[i].id].join('-'));

            row$.append($('<td/>').html(i + 1));
            row$.append($('<td/>').html(group[i].number));
            row$.append($('<td/>').html(group[i].buyer_name));
            if (group[i].internal_note) {
                row$.append($('<td/>').html(group[i].internal_note.split(',').join(', ')));
            } else {
                row$.append($('<td/>'));
            }
            row$.append($('<td align="right"/>').html(group[i].price_net));
            row$.append($('<td align="right"/>').html(group[i].price_tax));
            row$.append($('<td align="right"/>').html(group[i].price_gross));
            row$.append($('<td align="right"/>').html(getStatus(status[group[i].status], group[i].sent_time)));

            var actionShow = $('<img>');
            actionShow.attr('class', 'imgAkcja imgNormalLogs');
            actionShow.attr('onclick', 'invMgr.showInvoice("'+group[i].token+'","'+group[i].buyer_name+'")');

            //actionShow.attr('title', 'Pokaż fakturę');

            var actionDelete = $('<img>');
            actionDelete.attr('class', 'imgAkcja imgusun');
            actionDelete.attr('onclick', 'invMgr.removeInvoice("'+group[i].id+'","' + ['#colorbox #row',group[i].id].join('-') + '","' + getStatus(status[group[i].status], group[i].sent_time) + '")');

            row$.append($('<td align="right"/>').append(actionShow).append(actionDelete));

            body$.append(row$);
        }

        table$.append(body$);

        $('.invoice-details.' + key).empty().append(table$);

        $.colorbox({
            height:650+'px',
            width: 1185+'px',
            html: table$[0].outerHTML,
            title: group[0].buyer_name
        });
    };

    var getLocalization = function(agreement) {
        var localization = [];
        if (agreement["lokalizacja_ulica"]) {
            localization.push( agreement["lokalizacja_ulica"].split(' ').join('') );
        }

        if (agreement["lokalizacja_miasto"]) {
            localization.push( agreement["lokalizacja_miasto"] );
        }

        return localization.join(' ');
    };

    var getPositionDesc = function (str, agreement, showSerialNumber, showCounterState) {
        var desc = [
            str,
            agreement["model"]
        ];

        if (showSerialNumber) {
            desc.push(" (S/N:" + agreement["serial"] + ")");
        }

        if (showCounterState) {
            desc.push(getCounterState(agreement));
        }

        return desc.join(' ');
    };

    var getCounterState = function(agreement) {
        var counterState = "licznik:" + agreement["strony_black_koniec"];
        if (agreement["wartosckolor"] > 0) {
            counterState += "/" + agreement["strony_kolor_koniec"];
        }

        return counterState;
    };

    /**
     *
     * @param invoice
     * @param agreementIds
     * @returns {{api_token: *, invoice: {kind: string, number: null, seller_name: string, sell_date: string, issue_date: string, payment_to: string, buyer_name: string, buyer_tax_no: string, positions: *[]}}}
     */
    var getInvoiceParams = function(invoice, agreementIds) {

        var positions = [];

        $.each(invoice["umowy"], function(key, agreement) {

            if (agreementIds.indexOf(agreement["nrumowy"]) != -1) {
                positions.push({
                    "name": getPositionDesc("Wynajem drukarki", agreement, invoice['pokaznumerseryjny'], invoice['pokazstanlicznika']),
                    "additional_info": getLocalization(agreement),
                    "tax": 23,
                    "quantity": 1,
                    "quantity_unit" : "szt",
                    "total_price_gross": agreement["wartoscabonament"] * 1.23,
                    "discount_percent": 0
                });

                if (agreement["oplatainstalacyjna"] > 0) {
                    positions.push({
                        "name": getPositionDesc("Opłata instalacyjna", agreement, invoice['pokaznumerseryjny'], false),
                        "additional_info": getLocalization(agreement),
                        "tax": 23,
                        "quantity": 1,
                        "quantity_unit" : "szt",
                        "total_price_gross": agreement["oplatainstalacyjna"] * 1.23,
                        "discount_percent": 0
                    });
                }

                if (agreement["wartoscblack"] > 0) {
                    positions.push({
                        "name": getPositionDesc("Wydruki powyżej abonamentu", agreement, invoice['pokaznumerseryjny'], false),
                        "additional_info": getLocalization(agreement),
                        "tax": 23,
                        "quantity": agreement["stronblackpowyzej"],
                        "quantity_unit" : "szt",
                        "total_price_gross": agreement["stronblackpowyzej"] * agreement["cenazastrone"] * 1.23,
                        "discount_percent": 0
                    });
                }

                if (agreement["wartosckolor"] > 0) {
                    positions.push({
                        "name":getPositionDesc("Wydruki powyżej abonamentu", agreement, invoice['pokaznumerseryjny'], false),
                        "additional_info": getLocalization(agreement),
                        "tax": 23,
                        "quantity": agreement["stronkolorpowyzej"],
                        "quantity_unit" : "szt",
                        "total_price_gross": agreement["stronkolorpowyzej"] * agreement["cenazastrone_kolor"] * 1.23,
                        "discount_percent": 0
                    });
                }
            }
        });

        var invNumber = null;

        if (self.getMissingInvoices().length > 0) {
            invNumber = normalizeInvNb(self.getMissingInvoices()[0]);
        }

        return {
            "api_token": api_token,
            "invoice": {
                "kind":"vat",
                "number": invNumber,
                // "seller_name": company_name,
                "sell_date": dateFormat(getLastDayInMonth(currentPeriodInvoices.period.dateFrom)),
                "issue_date": dateFormat(getLastDayInMonth(currentPeriodInvoices.period.dateFrom)),
                "payment_to": dateFormat(addDaysToDate(getLastDayInMonth(currentPeriodInvoices.period.dateFrom),invoice['terminplatnosci'])),
                "buyer_name": invoice["nazwapelna"],
                "buyer_tax_no": invoice["nip"],
                "buyer_email": invoice["mailfaktury"],
                "buyer_post_code": invoice["kodpocztowy"],
                "buyer_city": invoice["miasto"],
                "buyer_street": invoice["ulica"],
                "positions":positions,
                "show_discount": "0",
                "internal_note": agreementIds.join(','),
                "seller_name": company_name,
                "additional_info": "1",
                "additional_info_desc": "Lokalizacja Urządzenia"
                // "description": "some test description" // uwagi
            }};
    };

    var normalizeInvNb = function(nb) {
        var nbLength = nb.split('/')[0].toString().length;

        for(var i = nbLength; i < invoice_number_length; i++) {
            nb = '0' + nb;
        }

        return nb;
    };
    
    var post = function(data, callback) {
        $.ajax({
            type: "POST",
            url: invoicesUrl,
            data: data,
            dataType: 'json',
            success: callback
        });
    };

    var put = function(url, data, callback) {
        $.ajax({
            url:url,
            type: 'post',
            data: $.extend({_method: 'put', api_token :api_token}, data),
            success: callback
        });
    };

    var del = function(url, callback) {
        $.ajax({
            url:url,
            type: 'post',
            data: {_method: 'delete', api_token :api_token},
            success: callback
        });
    };

    var get = function(params, callback) {
        var api_token_param = ["api_token", api_token].join('=');
        var request_params = params.join('&');
        request_params = [request_params, api_token_param].join('&');

        var url = [invoicesUrl, request_params].join('?');
        return $.get(url, callback);
    };

    var getClients = function(params, callback) {
        var api_token_param = ["api_token", api_token].join('=');
        var request_params = params.join('&');
        request_params = [request_params, api_token_param].join('&');

        var url = [clientsUrl, request_params].join('?');
        return $.get(url, callback);
    };

    var getFormattedDate = function(strDate) {
        var d = new Date(strDate);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        return [year,month,day].join('-');
    };

    /**
     * @param {string} date
     */
    var getLastDayInMonth = function(date) {
        var d = new Date(date);
        var dd = new Date(d.getFullYear(), d.getMonth()+1, 1);

        return new Date(dd-1);
    };

    var dateFormat = function(date) {
        var d = new Date(date);

        return d.toISOString().split('T')[0];
    };

    var addDaysToDate = function(date, days) {
        var d = new Date(date);
        d.setDate(d.getDate() + days);
        
        return d;
    };

    $(window).scroll(function(e){
        var $el = $('.errorMessageWrapper');
        var isPositionFixed = ($el.css('position') == 'fixed');
        if ($(this).scrollTop() > 69 && !isPositionFixed){
            $('.errorMessageWrapper').css({'position': 'fixed', 'top': '0px'});
        }
        if ($(this).scrollTop() <= 69 && isPositionFixed)
        {
            $('.errorMessageWrapper').css({'position': 'static', 'top': '0px'});
        }
    });

};