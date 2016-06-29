
InvoiceManager = function(api_token, endpoint, company_name) {

    var invoicesUrl = [endpoint, 'invoices.json'].join('/');
    var invoiceViewUrl = [endpoint, 'invoice'].join('/');

    var self = this;

    var currentPeriodInvoices = {
        period: null,
        invoices: []
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

    this.showInvoice = function(token, title) {
        var url = [invoiceViewUrl, token].join('/');
        window.open(url, title);
    };

    this.removeInvoice = function(id, rowSelector, status) {

        if (status == 'wystawiona') {

            var url = [endpoint, 'invoices', [id, 'json'].join('.')].join('/');

            if (confirm('Czy na pewno chcesz usunąć fakturę?')) {
                del(url, function (inv) {
                    alert('Faktura została usunięta!');
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
            var message = (Object.keys(invoice['umowy']).length == agreementIds.length) ?
                "Tworzysz fakturę dla wszystkich umów. Potwierdzasz ?" :
                "Tworzysz fakturę dla " + agreementIds.length + " z " + Object.keys(invoice['umowy']).length + " umów. Powierdzasz ?";
            if (confirm(message)) {
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
    this.refreshInvoices = function (period) {
        if (period) {
            currentPeriodInvoices.period = period;
        }

        if (currentPeriodInvoices.period) {
            var params = [];
            params.push("period=more");
            params.push(["date_from", currentPeriodInvoices.period.dateFrom].join('='));
            params.push(["date_to", currentPeriodInvoices.period.dateTo].join('='));
            get(params, function (invoices, status) {

                currentPeriodInvoices.invoices = invoices;

                // groupByClient
                var groupedInvoices = {};
                $.each(invoices, function (index, invoice) {
                    if (!groupedInvoices[invoice['buyer_tax_no']]) {
                        groupedInvoices[invoice['buyer_tax_no']] = [];
                    }

                    groupedInvoices[invoice['buyer_tax_no']].push(invoice);
                });

                // reset all invoice counts
                $('.invoice-count').text('0').css({'color':'red'});


                // set initial state for all agreements, visible and selected
                $('.to_invoice_agreement').prop('checked', true).show();

                // set new invoice counts
                $.each(groupedInvoices, function (key, group) {
                    $('.invoice-count.' + key).text(group.length).click(function() {
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
                })
            });
        } else {
            console.log('could not get invoices, no period defined');
        }
    };

    /**
     * @type {{dateFrom: *, dateTo: *}} period
     */
    this.showAgreementWarnings = function(period) {
        $('.agreements-list').each(function(idx, list) {

            var anyWarning = false;
            $(list).find('.agreement-nb').each(function(index, agreement) {
                var blackenddate = $(agreement).attr('blackenddate');
                var colorenddate = $(agreement).attr('colorenddate');

                if (blackenddate && blackenddate != '0000-00-00') {
                    if (blackenddate.split(' ')[0] != dateFormat(period.dateTo)) {
                        $(agreement).find('.fa.fa-exclamation-triangle').show();
                        anyWarning = true;
                    }
                }

                if (colorenddate && colorenddate != '0000-00-00') {
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
    };

    var createInvoiceListView = function(key, group) {

        var table$ = $('<table />').attr('class', 'tablesorter displaytable');

        var head$ = $('<thead />');

        [{'name': 'Lp', 'width': '15px'}, {'name': 'Nazwa klienta', 'width': '220px'}, {'name': 'Umowy', 'width': '220px'}, {'name': 'Cena netto', 'width': '100px'}, {'name': 'Wartość VAT', 'width': '100px'}, {'name': 'Wartość brutto', 'width': '100px'}, {'name':'Status', 'width': '100px'}, {'name':'', 'width': '100px'}].forEach(function(th) {
            head$.append($('<th>').attr('style', ['width', th['width']].join(':')).html(th['name']));
        });

        table$.append(head$);

        var body$ = $('<tbody />');

        for(var i=0; i < group.length; i++) {
            row$ = $('<tr/>').attr('id', ['row', group[i].id].join('-'));

            row$.append($('<td/>').html(i + 1));
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
                    "name": "Wynajem drukarki " + agreement["model"],
                    "tax": 23,
                    "quantity": 1,
                    "quantity_unit" : "szt",
                    // "price_net": agreement["wartoscabonament"],
                    "total_price_gross": agreement["wartoscabonament"] * 1.23,
                    "discount_percent": 0
                });

                if (agreement["oplatainstalacyjna"] > 0) {
                    positions.push({
                        "name": "Opłata instalacyjna " + agreement["model"],
                        "tax": 23,
                        "quantity": 1,
                        "quantity_unit" : "szt",
                        // "price_net": agreement["oplatainstalacyjna"],
                        "total_price_gross": agreement["oplatainstalacyjna"] * 1.23,
                        "discount_percent": 0
                    });
                }

                if (agreement["wartoscblack"] > 0) {
                    positions.push({
                        "name": "Wydruki powyżej abonamentu " + agreement["model"],
                        "tax": 23,
                        "quantity": agreement["stronblackpowyzej"],
                        "quantity_unit" : "szt",
                        //"price_net": agreement["cenazastrone"],
                        "total_price_gross": agreement["stronblackpowyzej"] * agreement["cenazastrone"] * 1.23,
                        "discount_percent": 0
                    });
                }

                if (agreement["wartosckolor"] > 0) {
                    positions.push({
                        "name": "Wydruki powyżej abonamentu " + agreement["model"],
                        "tax": 23,
                        "quantity": agreement["stronkolorpowyzej"],
                        "quantity_unit" : "szt",
                        // "price_net": agreement["cenazastrone_kolor"],
                        "total_price_gross": agreement["stronkolorpowyzej"] * agreement["cenazastrone_kolor"] * 1.23,
                        "discount_percent": 0
                    });
                }
            }
        });

        return {
            "api_token": api_token,
            "invoice": {
                "kind":"vat",
                "number": null,
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
                "show_discount": "1",
                "internal_note": agreementIds.join(',')
                // "description": "some test description" // uwagi
            }};
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

    var get = function(params, callback) {
        var api_token_param = ["api_token", api_token].join('=');
        var request_params = params.join('&');
        request_params = [request_params, api_token_param].join('&');

        var url = [invoicesUrl, request_params].join('?');
        $.get(url, callback);
    };

    var del = function(url, callback) {
        $.ajax({
            url:url,
            type: 'post',
            data: {_method: 'delete', api_token :api_token},
            success: callback
        });
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
    }
    
};