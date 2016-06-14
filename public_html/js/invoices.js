
InvoiceManager = function(api_token, endpoint, company_name) {

    var invoicesUrl = [endpoint, 'invoices.json'].join('/');
    var invoiceViewUrl = [endpoint, 'invoice'].join('/');

    var self = this;

    var currentPeriodInvoices = {
        period: null,
        invoices: []
    };

    this.showInvoice = function(token, title) {
        var url = [invoiceViewUrl, token].join('/');
        window.open(url, title);
    };

    this.removeInvoice = function(id) {
        var url = [endpoint, 'invoices', [id,'json'].join('.')].join('/');
        console.log([url, ['api_token', api_token].join('=')].join('?') );
        del(url, function(inv) {
            alert(inv);
        });
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
                $('.invoice-count').text('0').css({'color':'red', 'position': 'relative', 'top': '-3px', 'left':'10px'});

                // set new invoice counts
                $.each(groupedInvoices, function (key, group) {
                    $('.invoice-count.' + key).text(group.length).css({'color':'green', 'font-weight': 'bold', 'cursor':'pointer', 'position': 'relative', 'top': '-3px', 'left':'10px'}).click(function() {

                        var table$ = $('<table />');

                        var row$ = $('<tr/>');

                        ['Nazwa klienta', 'Cena netto', 'Wartość VAT', 'Wartość brutto', ''].forEach(function(th) {
                            row$.append($('<th>').html(th));
                        });

                        table$.append(row$);

                        for(var i=0; i < group.length; i++) {
                            row$ = $('<tr/>');

                            row$.append($('<td/>').html(group[i].buyer_name));
                            row$.append($('<td/>').html(group[i].price_net));
                            row$.append($('<td/>').html(group[i].price_tax));
                            row$.append($('<td/>').html(group[i].price_gross));

                            var actionShow = $('<img>');
                            actionShow.attr('class', 'imgAkcja imgNormalLogs');
                            actionShow.attr('onclick', 'invMgr.showInvoice("'+group[i].token+'","'+group[i].buyer_name+'")');

                            //actionShow.attr('title', 'Pokaż fakturę');

                            var actionDelete = $('<img>');
                            actionDelete.attr('class', 'imgAkcja imgusun').click(function() {alert('clicked')});
                            actionDelete.attr('onclick', 'invMgr.removeInvoice("'+group[i].id+'")');

                            //actionDelete.attr('title', 'Pokaż fakturę');


                            row$.append($('<td/>').append(actionShow).append(actionDelete));

                            table$.append(row$);

                            $('.invoice-details.' + key).empty().append(table$);
                        }

                        $.colorbox({
                            height:650+'px',
                            width: 600+'px',
                            html:['<table>', table$.html(), '</table>'].join(),
                            title: group[0].buyer_name
                        });
                    });

                })
            });
        } else {
            console.log('could not get invoices, no period defined');
        }
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
                "positions":positions,
                "show_discount": "1"
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
        var api_token_param = ["api_token", api_token].join('=');
        $.ajax({
            url: url,
            type: 'DELETE',
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