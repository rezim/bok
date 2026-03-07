const yesterday = function (strDate) {
    const d = new Date(strDate);
    d.setDate(d.getDate() - 1);

    const year = d.getFullYear();
    const month = d.getMonth() + 1 >= 10 ? d.getMonth() + 1 : `0${d.getMonth() + 1}`;
    const day = d.getDate() >= 10 ? d.getDate() : `0${d.getDate()}`;

    return `${year}-${month}-${day}`;
};

const MY_BENEFIT_NIP = "8361676510";
const QUALITY_CONTROL_NIP = "1133019329";

InvoiceManager = function (invoice_number_length) {

    const self = this;

    const currentPeriodInvoices = {
        period: null,
        invoices: [],
        orderedInvoices: []
    };

    const status = {
        issued: "wystawiona",
        sent: "wysłana",
        paid: "opłacona",
        partial: "częściowo opłacona",
        rejected: "odrzucona"
    };

    const getStatus = function (invStatus, sentTime) {
        let result = invStatus;
        if (result == 'wystawiona' && sentTime) {
            result = 'wysłana';
        }

        return result;
    };

    const getAjaxErrorMessage = function (error) {
        if (error && error.responseJSON) {
            if (typeof error.responseJSON.message === 'string' && error.responseJSON.message.trim() !== '') {
                return error.responseJSON.message;
            }
            return JSON.stringify(error.responseJSON);
        }

        if (error && typeof error.responseText === 'string' && error.responseText.trim() !== '') {
            try {
                const parsed = JSON.parse(error.responseText);
                if (parsed && typeof parsed.message === 'string' && parsed.message.trim() !== '') {
                    return parsed.message;
                }
            } catch (ignored) {
                // Keep raw responseText when it's not JSON.
            }

            return error.responseText;
        }

        return 'Nieznany błąd.';
    };

    this.reportData = null;

    this.setReportData = function (data) {
        this.reportData = data;
    };

    this.getReportData = function () {
        return this.reportData;
    };

    this.getInvoices = function () {
        return currentPeriodInvoices.invoices;
    };

    this.getMissingInvoices = function () {
        return currentPeriodInvoices.missingInvoices;
    };

    this.showInvoice = function (url, title) {
        const secureUrl = url.replace('http://', 'https://');
        window.open(secureUrl, title);
    };

    this.getLastInvoice = function () {
        var invoices = this.getInvoices();
        var last;
        invoices.forEach(function (invoice) {
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

    this.getInvoiceById = function (id) {
        var invoices = this.getInvoices();

        return invoices.find(function (val) {
            return val.id == id
        })
    };

    this.removeInvoice = async function (id, rowSelector, status) {
        if (status == 'wystawiona') {
            if (confirm('Czy na pewno chcesz usunąć fakturę?')) {

                await loadAsyncData('/clientinvoices/removeinvoicebyid/notemplate', {invoice_id: id});

                self.refreshInvoices();
                $(rowSelector).remove();
            }
        } else {
            alert('Nie moża usunąć faktury, której status jest "' + status + '"!');
        }
    };

    var lockAdd = false;
    this.add = async function (key) {

        const invoice = this.reportData[key];
        if (!invoice) {
            return;
        }

        const agreementIds = this.getSelectedAgreementIds(`#tr_${key}`, ".to_invoice_agreement:checked");

        if (agreementIds && agreementIds.length > 0 && !lockAdd) {

            let errorMsg = '';
            let groupedAgreementIds;

            if (invoice['fakturadlakazdejumowy']) {
                groupedAgreementIds = Object.values(agreementIds).map(agreementId => [agreementId]);
            } else if (invoice['nip'] === MY_BENEFIT_NIP) {
                groupedAgreementIds = this.groupByDeviceType(Object.values(invoice['umowy']), agreementIds);
            } else if (invoice['nip'] === QUALITY_CONTROL_NIP) {
                groupedAgreementIds = this.groupByGivenAgreementIds(Object.values(invoice['umowy']), agreementIds, ['14/03/2022']);
            } else {
                groupedAgreementIds = this.groupByRecipient(Object.values(invoice['umowy']), agreementIds);
            }

            lockAdd = true;

            for (const agrIds of groupedAgreementIds) {
                const params = getInvoiceParams(invoice, agrIds);

                console.log(params);

                let createdInvoice = null;
                try {
                    const newInvoice = await loadAsyncData('/clientinvoices/addnewinvoice/notemplate', params);
                    createdInvoice = typeof newInvoice === 'string' ? JSON.parse(newInvoice) : newInvoice;
                } catch (e) {
                    errorMsg += `Błąd!, nie można wystawić FV dla '${invoice['nazwapelna']}', komunikat błędu: ${getAjaxErrorMessage(e)}! `;
                    continue;
                }

                if (window.ENABLE_ADD_INTEREST_NOTES_TO_INVOICE === true
                    && createdInvoice
                    && createdInvoice.id
                    && createdInvoice.buyer_tax_no) {
                    try {
                        await loadAsyncData('/clientinvoices/addinterestnotestoinvoice/notemplate', {
                            invoice_id: createdInvoice.id,
                            nip: createdInvoice.buyer_tax_no
                        });
                    } catch (e) {
                        errorMsg += `Błąd!, nie można dołaczyć not odsetkowych do wystawionej faktury, komunikat błędu: ${getAjaxErrorMessage(e)}! `;
                    }
                }
            }
            await this.refreshInvoices();

            lockAdd = false;

            if (errorMsg !== '') {
                this.showActionError(true, errorMsg);
            } else {
                this.showActionError(false);
            }

        } else {
            alert("Wybierz przynajmniej jedną umowę!");
        }
    };

    this.addAll = async function () {
        if (!this.reportData) {
            return;
        }
        let errorMsg = '';
        for (const [key, report] of Object.entries(this.reportData)) {

            if (key !== 'suma' && key !== 'blad' && report['blad'] !== 1) {

                const agreementIds = this.getSelectedAgreementIds(`#tr_${key}`, ".to_invoice_agreement:checked");

                if (agreementIds && agreementIds.length > 0 && !lockAdd) {

                    let groupedAgreementIds;

                    if (report['fakturadlakazdejumowy']) {
                        groupedAgreementIds = Object.values(agreementIds).map(agreementId => [agreementId]);
                    } else if (report['nip'] === MY_BENEFIT_NIP) {
                        groupedAgreementIds = this.groupByDeviceType(Object.values(report['umowy']), agreementIds);
                    } else {
                        groupedAgreementIds = this.groupByRecipient(Object.values(report['umowy']), agreementIds);
                    }

                    for (const agrIds of groupedAgreementIds) {
                        const params = getInvoiceParams(report, agrIds);
                        let createdInvoice = null;
                        try {
                            const newInvoice = await loadAsyncData('/clientinvoices/addnewinvoice/notemplate', params);
                            createdInvoice = typeof newInvoice === 'string' ? JSON.parse(newInvoice) : newInvoice;
                        } catch (e) {
                            errorMsg += `Błąd!, nie można wystawić FV dla '${report['nazwapelna']}', komunikat błędu: ${getAjaxErrorMessage(e)}! `;
                            continue;
                        }

                        if (window.ENABLE_ADD_INTEREST_NOTES_TO_INVOICE === true
                            && createdInvoice
                            && createdInvoice.id
                            && createdInvoice.buyer_tax_no) {
                            try {
                                await loadAsyncData('/clientinvoices/addinterestnotestoinvoice/notemplate', {
                                    invoice_id: createdInvoice.id,
                                    nip: createdInvoice.buyer_tax_no
                                });
                            } catch (e) {
                                errorMsg += `Błąd!, nie można dołaczyć not odsetkowych do wystawionej faktury, komunikat błędu: ${getAjaxErrorMessage(e)}! `;
                            }
                        }
                    }

                }

            }
        }

        await this.refreshInvoices();

        if (errorMsg !== '') {
            this.showActionError(true, errorMsg);
        } else {
            this.showActionError(false);
        }
    };

    this.groupByRecipient = function (agreements, agreementIds) {

        const groupedAgreements = agreementIds.reduce(
            (result, agreementId) => {
                const agreement = agreements.find(agreement => agreement.nrumowy === agreementId);
                if (agreement) {
                    result[agreement.odbiorca_id] = result[agreement.odbiorca_id] || [];
                    result[agreement.odbiorca_id].push(agreementId);
                }
                return result;
            }, Object.create(null));

        return Object.values(groupedAgreements);
    };


    this.groupByGivenAgreementIds = function (agreements, agreementIds, givenAgreementIds = []) {

        const allAgreements = agreements.filter(agreement => agreementIds.indexOf(agreement.nrumowy) !== -1);

        const givenAgreements = allAgreements.filter(agreement => givenAgreementIds.indexOf(agreement['nrumowy']) !== -1);

        const remainingAgreements = allAgreements.filter(agreement => givenAgreementIds.indexOf(agreement['nrumowy']) === -1);

        const result = [];

        if (givenAgreements.length) {
            result.push(givenAgreements.map(given => given.nrumowy));
        }
        if (remainingAgreements.length) {
            result.push(remainingAgreements.map(remaining => remaining.nrumowy));
        }

        return result;
    };

    this.groupByDeviceType = function (agreements, agreementIds) {

        const allAgreements = agreements.filter(agreement => agreementIds.indexOf(agreement.nrumowy) !== -1);

        const printers = allAgreements.filter(agreement => agreement['typ_umowy'] === "wynajem drukarki");

        const nonPrinters = allAgreements.filter(agreement => agreement['typ_umowy'] !== "wynajem drukarki");

        const result = [];

        if (printers.length) {
            result.push(printers.map(printer => printer.nrumowy));
        }
        if (nonPrinters.length) {
            result.push(nonPrinters.map(nonPrinter => nonPrinter.nrumowy));
        }

        return result;
    };

    /**
     *
     * @param clientSelector
     * @param agreementSelector
     * @returns {Array}
     */
    this.getSelectedAgreementIds = function (clientSelector, agreementSelector) {
        var selectedAgreementIds = [];
        $([clientSelector, agreementSelector].join(" ")).map(function () {
            selectedAgreementIds.push($(this).val());
        });

        return selectedAgreementIds;
    };

    /**
     * @type {{dateFrom: *, dateTo: *}} period
     */
    this.refreshInvoices = async function (period, callback) {
        if (period) {
            currentPeriodInvoices.period = period;
        }

        if (currentPeriodInvoices.period) {
            $('.invoice-count').hide();
            $('.invoice-loading').show();

            // [TODO TR]: use methods from service instead
            const containerId = 'dataFilter';
            const containerSelector = `#${containerId}[data-form]`;
            const container = document.querySelector(containerSelector);
            const filterRefs = Array.from(container.querySelectorAll('[data-ref]'));
            const filterData = Object.fromEntries(filterRefs.map(d => [d.id, d.type === 'checkbox' ? d.checked : d.value]));
            const anyFilterSet = Object.values(filterData).some(v => !!v);


            let loadedInvoices = await loadAsyncData('/reports/getinvoices/notemplate', {
                period: 'more',
                date_from: currentPeriodInvoices.period.dateFrom,
                date_to: yesterday(currentPeriodInvoices.period.dateTo),
                ...filterData
            });

            loadedInvoices = JSON.parse(loadedInvoices);

            $('.invoice-count').show();
            $('.invoice-loading').hide();

            // for invoices from Proforma invoices pattern is with P but number without,
            // probably bug on Fakturowania side
            let invoices = loadedInvoices.filter(inv =>
                (inv['kind'] === 'vat' && (inv['pattern'] === 'nr-m/mm/yyyy' ||
                    (inv['pattern'] === 'Pnr-m/mm/yyyy' && inv['number']?.charAt(0) !== 'P')))
            );

            currentPeriodInvoices.invoices = invoices;

            // var orderedInvoices = Array.apply(null, Array(invoices.length)).map(function () {
            //     return 0;
            // });
            //
            // // groupByClient
            // var groupedInvoices = {};
            //
            // var invNbPattern = null;
            //
            // $.each(invoices, function (index, invoice) {
            //     var buyerTaxNo = invoice['buyer_tax_no'] || invoice['buyer_id'];
            //     if (!groupedInvoices[buyerTaxNo]) {
            //         groupedInvoices[buyerTaxNo] = [];
            //     }
            //
            //     groupedInvoices[buyerTaxNo].push(invoice);
            //
            //     var invoiceIdx = parseInt(invoice.number.split('/')[0]) - 1;
            //
            //     if (invoiceIdx === orderedInvoices.length) {
            //         orderedInvoices.push(0);
            //     }
            //
            //     orderedInvoices[invoiceIdx]++;
            //
            //     if (!invNbPattern) {
            //         invNbPattern = invoice.number.split('/');
            //         invNbPattern.shift();
            //         invNbPattern = invNbPattern.join('/');
            //     }
            // });
            var groupedInvoices = {};

            // Group invoices by buyer and extract invoice numbers
            $.each(invoices, function (index, invoice) {
                var buyerTaxNo = invoice['buyer_tax_no'] || invoice['buyer_id'];

                if (!groupedInvoices[buyerTaxNo]) {
                    groupedInvoices[buyerTaxNo] = [];
                }

                groupedInvoices[buyerTaxNo].push(invoice);

                // Extract invoice number before the first slash
                var parts = invoice.number.split('/');
                var nb = parseInt(parts[0], 10);
            });

            var missingInvoices = [];
            var debugCurrentMonthPattern = null;
            var debugCurrentMonthInvoiceNumbers = [];
            var debugInvoiceContinuity = window.__DEBUG_INVOICE_CONTINUITY__ !== false;
            var debugSimulation = window.__INVOICE_CONTINUITY_SIMULATION__ || null;
            var debugSimulationApplied = null;

            if (!anyFilterSet) {
                var now = new Date();
                var currentMonth = String(now.getMonth() + 1).padStart(2, '0');
                var currentYear = String(now.getFullYear());
                var currentMonthPattern = currentMonth + '/' + currentYear;
                debugCurrentMonthPattern = currentMonthPattern;

                // Continuity is checked only for invoices numbered in the current month.
                var currentMonthInvoiceNumbers = [];
                $.each(invoices, function (_, invoice) {
                    var parts = (invoice.number || '').split('/');
                    if (parts.length < 3) {
                        return;
                    }

                    var pattern = parts.slice(1).join('/');
                    if (pattern !== currentMonthPattern) {
                        return;
                    }

                    var nb = parseInt(parts[0], 10);
                    if (!isNaN(nb)) {
                        currentMonthInvoiceNumbers.push(nb);
                    }
                });

                // Debug-only: simulate continuity issues without changing real invoices in Fakturownia.
                if (debugSimulation && debugSimulation.enabled) {
                    var simAction = debugSimulation.action;
                    var simNumber = parseInt(debugSimulation.number, 10);

                    if (!isNaN(simNumber)) {
                        if (simAction === 'remove') {
                            var beforeLength = currentMonthInvoiceNumbers.length;
                            currentMonthInvoiceNumbers = currentMonthInvoiceNumbers.filter(function (nb) {
                                return nb !== simNumber;
                            });
                            debugSimulationApplied = {
                                action: simAction,
                                number: simNumber,
                                removedCount: beforeLength - currentMonthInvoiceNumbers.length
                            };
                        }

                        if (simAction === 'add') {
                            currentMonthInvoiceNumbers.push(simNumber);
                            debugSimulationApplied = {
                                action: simAction,
                                number: simNumber,
                                addedCount: 1
                            };
                        }
                    }
                }

                debugCurrentMonthInvoiceNumbers = currentMonthInvoiceNumbers.slice();

                // If there are no invoices, nothing to validate
                if (currentMonthInvoiceNumbers.length === 0) {
                    missingInvoices = [];
                } else {
                    var minNb = Math.min.apply(null, currentMonthInvoiceNumbers);
                    var maxNb = Math.max.apply(null, currentMonthInvoiceNumbers);

                    // Use a simple lookup map for existing invoice numbers
                    var seen = {};
                    $.each(currentMonthInvoiceNumbers, function (_, nb) {
                        seen[nb] = true;
                    });

                    // Find numbers in the range [min..max] that never occurred
                    for (var n = minNb; n <= maxNb; n++) {
                        if (!seen[n]) {
                            missingInvoices.push(n + '/' + currentMonthPattern);
                        }
                    }
                }
            }

            currentPeriodInvoices.missingInvoices = missingInvoices;

            if (debugInvoiceContinuity) {
                console.info('[Invoice continuity debug]', {
                    anyFilterSet: anyFilterSet,
                    currentMonthPattern: debugCurrentMonthPattern,
                    currentMonthInvoiceNumbers: debugCurrentMonthInvoiceNumbers,
                    simulation: debugSimulationApplied,
                    missingInvoices: missingInvoices,
                    totalLoadedInvoices: invoices.length
                });
            }

            // reset all invoice counts
            updateInvoiceCountStyle('.invoice-count', false);
            $('.invoice-count').text('0');


            // set initial state for all agreements, visible and selected
            $('.to_invoice_agreement').prop('checked', true).show();

            // set new invoice counts
            $.each(groupedInvoices, function (key, group) {

                // fix for a case, if client has not NIP,
                // then the format of NIP is: PESEL : 123456
                if (key.startsWith('Pesel')) {
                    return;
                }

                $('.invoice-count.' + key).text(group.length).unbind('click');

                $('.invoice-count.' + key).text(group.length).bind('click', function () {
                    createInvoiceListView(key, group);
                });

                //TODO: move it to separate function
                var sum = 0;
                for (var i = 0; i < group.length; i++) {
                    sum += parseFloat(group[i].price_net);
                }
                $('.invoice-sum.' + key).text(sum.toFixed(2)).unbind('click');
                $('.invoice-sum.' + key).text(sum.toFixed(2)).bind('click', function () {
                    createInvoiceListView(key, group);
                });

                var allAgrCount = 0;
                var selector = [];
                var selectorPrefix = ['.agreements-list', key].join('.');

                group.forEach(function (invoice) {
                    var agreements = (invoice.internal_note) ? invoice.internal_note.split(',') : [];
                    if (agreements.length > 0) {
                        agreements.forEach(function (agreement) {
                            // split().join() instead of replace all which is not defined :/
                            selector.push([selectorPrefix, ['.', agreement.split('/').join('-')].join(''), '.to_invoice_agreement'].join(' '));
                        });
                    }
                    allAgrCount += agreements.length;
                });
                // uncheck and hide all agreements already on invoice
                $(selector.join(',')).prop('checked', false).hide();

                if ($([selectorPrefix, ".to_invoice_agreement"].join(' ')).length != allAgrCount) {
                    updateInvoiceCountStyle('.invoice-count.' + key, false);
                    // $('.invoice-count.' + key).css({'color':'red', 'font-weight': 'bold'});
                } else {
                    updateInvoiceCountStyle('.invoice-count.' + key, true);
                    // $('.invoice-count.' + key).css({'color':'green', 'font-weight': 'bold'});
                }
            });

            if (self.getMissingInvoices().length > 0) {
                var missing = self.getMissingInvoices();
                var previewLimit = 5;
                var preview = missing.slice(0, previewLimit).join(', ');
                var remainingCount = Math.max(0, missing.length - previewLimit);
                var message = `Uwaga: brak ciągłości numeracji faktur (${missing.length} brakujących numerów).`;

                if (preview.length > 0) {
                    message += ` Przykłady: ${preview}`;
                    if (remainingCount > 0) {
                        message += ` i ${remainingCount} więcej.`;
                    } else {
                        message += '.';
                    }
                }

                this.showActionError(true, message);
            } else {
                this.showActionError(false);
            }

            if (callback) {
                callback();
            }

        } else {
            console.log('could not get invoices, no period defined');
        }
    };

    this.showActionError = function (show, message) {
        const actionErrorSelector = '#actionerror';
        const actionError = $(actionErrorSelector);

        if (show) {
            actionError.css({
                position: 'relative',
                height: 'auto',
                'min-height': '50px',
                padding: '12px 44px 12px 14px',
                'text-align': 'left',
                'box-sizing': 'border-box'
            });

            const closeButton = $('<button/>', {
                type: 'button',
                'aria-label': 'Zamknij komunikat',
                title: 'Zamknij',
                class: 'invoice-error-close',
                html: '&times;'
            }).attr('style', [
                'position:absolute',
                'top:8px',
                'right:10px',
                'border:0',
                'background:transparent',
                'font-size:22px',
                'line-height:1',
                'cursor:pointer',
                'color:#a94442'
            ].join(';'));

            const content = $('<div/>').append(
                $('<div/>').attr('style', 'font-weight:bold;line-height:1.35;margin:0;').append(
                    $('<i/>', {class: 'fas fa-exclamation-triangle'}),
                    document.createTextNode(' ' + message)
                ),
                closeButton
            );

            actionError.empty().append(content).show();
            actionError.off('click.invoiceErrorClose').on('click.invoiceErrorClose', '.invoice-error-close', function () {
                self.showActionError(false);
            });
        } else {
            actionError.off('click.invoiceErrorClose').html('').hide();
        }
    };

    /**
     * @type {{dateFrom: *, dateTo: *}} period
     */
    this.showAgreementWarnings = function (period) {
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

    this.showClientWithAllIssuedInvoices = function (show) {
        if (show) {
            $('.allInvoicesIssued:not(.hasError)').show();
        } else {
            $('.allInvoicesIssued:not(.hasError)').hide();
        }
    };

    const createInvoiceListView = function (key, group) {

        const table$ = $('<table />').attr('class', 'tablesorter displaytable');

        const head$ = $('<thead />');

        [{'name': 'Lp', 'width': '20px'}, {'name': 'Numer', 'width': '120px'}, {
            'name': 'Nazwa klienta',
            'width': '250px'
        }, {'name': 'Umowy', 'width': '120px'}, {'name': 'Netto', 'width': '100px', 'text-align': 'right'}, {
            'name': 'VAT',
            'width': '100px', 'text-align': 'right'
        }, {'name': 'Brutto', 'width': '100px', 'text-align': 'right'}, {
            'name': 'Status',
            'width': '100px',
            'text-align': 'center'
        }, {
            'name': '',
            'width': '100px'
        }].forEach(function (th) {
            head$.append($('<th>').attr('style', `width: ${th['width']}; text-align: ${th['text-align']};`).html(th['name']));
        });

        table$.append(head$);

        const body$ = $('<tbody />');

        for (let i = 0; i < group.length; i++) {

            const {id, number, buyer_name, internal_note, price_net, price_tax, price_gross, sent_time, view_url} = group[i];
            const invoice_status = group[i].status;

            const row$ = $('<tr/>').attr('id', ['row', id].join('-'));

            row$.append($('<td/>').html(i + 1));
            row$.append($('<td/>').html(number));
            row$.append($('<td/>').html(buyer_name));
            if (internal_note) {
                row$.append($('<td/>').html(internal_note.split(',').join(', ')));
            } else {
                row$.append($('<td/>'));
            }
            row$.append($('<td align="right"/>').html(price_net));
            row$.append($('<td align="right"/>').html(price_tax));
            row$.append($('<td align="right"/>').html(price_gross));
            row$.append($('<td align="right"/>').html(getStatus(status[invoice_status], sent_time)));

            const actionShow = $('<i>');
            actionShow.attr('class', 'fas fa-search cursor-pointer text-success mr-3');
            actionShow.attr('onclick', 'invMgr.showInvoice("' + view_url + '","' + buyer_name + '")');

            const actionDelete = $('<i>');
            actionDelete.attr('class', 'fas fa-times-circle cursor-pointer text-danger mr-1');
            actionDelete.attr('onclick', 'invMgr.removeInvoice("' + id + '","' + ['#colorbox #row', id].join('-') + '","' + getStatus(status[invoice_status], sent_time) + '")');

            row$.append($('<td align="right" style="font-size: 20px" />').append(actionShow).append(actionDelete));

            body$.append(row$);
        }

        table$.append(body$);

        $('.invoice-details.' + key).empty().append(table$);

        $.colorbox({
            height: 650 + 'px',
            width: 1185 + 'px',
            html: table$[0].outerHTML,
            title: group[0].buyer_name
        });
    };

    var getLocalization = function (agreement) {
        var localization = [];

        if (agreement["lokalizacja_miasto"]) {
            localization.push(agreement["lokalizacja_miasto"]);
        }

        return localization.join(' ');
    };

    var getPositionDesc = function (str, agreement, showSerialNumber, showCounterState) {
        const localization = getLocalization(agreement);

        var desc = [
            str,
            agreement["model"]
        ];

        // collect elements that should appear inside a single bracket
        var bracketParts = [];

        if (localization) {
            bracketParts.push(`lokalizacja: ${localization}`);
        }

        if (showSerialNumber && agreement["serial"]) {
            bracketParts.push(`S/N: ${agreement["serial"]}`);
        }

        // if we have any bracket elements, append them as one combined bracket
        if (bracketParts.length > 0) {
            desc.push(`(${bracketParts.join(', ')})`);
        }

        if (showCounterState) {
            desc.push(getCounterState(agreement));
        }

        return desc.join(' ');
    };

    var getCounterState = function (agreement) {
        let counterState = `licznik: ${agreement['strony_black_koniec']}`;
        if (agreement["strony_kolor_koniec"]) {
            counterState += `/ ${agreement['strony_kolor_koniec']}`;
        }
        if (agreement["skany_koniec"]) {
            counterState += `, skany: ${agreement['skany_koniec']}`;
        }

        return counterState;
    };

    /**
     *
     * @param invoice
     * @param agreementIds
     * @returns {{buyer_email: *, show_discount: string, kind: string, buyer_street: *, buyer_name: *, positions: [], internal_note: string, buyer_city: *, additional_info_desc: string, number: null, sell_date: *, buyer_post_code: *, issue_date: *, buyer_tax_no: *, additional_info: string, payment_to: *, recipient_id: (string)}}
     */
    var getInvoiceParams = function (invoice, agreementIds) {

        var positions = [];

        var recipient_id = null;

        $.each(invoice["umowy"], function (key, agreement) {

            if (agreementIds.indexOf(agreement["nrumowy"]) !== -1) {

                recipient_id = recipient_id || agreement["odbiorca_id"];

                var title = '';

                switch (agreement["typ_umowy"]) {
                    case 'wynajem drukarki':
                        title = getPositionDesc("Wynajem drukarki", agreement, invoice['pokaznumerseryjny'], invoice['pokazstanlicznika']);
                        break;
                    case 'wynajem domeny':
                        title = getPositionDesc("Opłata za domenę", agreement);
                        break;
                    case 'hosting':
                        title = getPositionDesc("Opłata za hosting", agreement);
                        break;
                    case 'wynajem niszczarki':
                        title = getPositionDesc("Wynajem niszczarki", agreement, invoice['pokaznumerseryjny'], invoice['pokazstanlicznika']);
                        break;
                    default:
                        title = getPositionDesc(`${agreement["typ_umowy"][0].toUpperCase()}${agreement["typ_umowy"].slice(1)}`, agreement, invoice['pokaznumerseryjny']);
                }

                // TODO TR: remove additional_info (it should by moved to counters)
                positions.push({
                    "name": title,
                    "tax": 23,
                    "quantity": 1,
                    "quantity_unit": "szt",
                    "total_price_gross": agreement["wartoscabonament"] * 1.23,
                    "discount_percent": 0
                });

                if (agreement["oplatainstalacyjna"] > 0) {
                    positions.push({
                        "name": getPositionDesc("Opłata instalacyjna", agreement, invoice['pokaznumerseryjny'], false),
                        "tax": 23,
                        "quantity": 1,
                        "quantity_unit": "szt",
                        "total_price_gross": agreement["oplatainstalacyjna"] * 1.23,
                        "discount_percent": 0
                    });
                }

                if (agreement["wartoscblack"] > 0) {
                    positions.push({
                        "name": getPositionDesc("Wydruki powyżej abonamentu", agreement, invoice['pokaznumerseryjny'], false),
                        "tax": 23,
                        "quantity": agreement["stronblackpowyzej"],
                        "quantity_unit": "szt",
                        "total_price_gross": agreement["stronblackpowyzej"] * agreement["cenazastrone"] * 1.23,
                        "discount_percent": 0
                    });
                }

                if (agreement["wartosckolor"] > 0) {
                    positions.push({
                        "name": getPositionDesc("Wydruki powyżej abonamentu", agreement, invoice['pokaznumerseryjny'], false),
                        "tax": 23,
                        "quantity": agreement["stronkolorpowyzej"],
                        "quantity_unit": "szt",
                        "total_price_gross": agreement["stronkolorpowyzej"] * agreement["cenazastrone_kolor"] * 1.23,
                        "discount_percent": 0
                    });
                }

                if (agreement["wartoscscans"] > 0) {
                    positions.push({
                        "name": getPositionDesc("Skany powyżej abonamentu", agreement, invoice['pokaznumerseryjny'], false),
                        "tax": 23,
                        "quantity": agreement["scanspowyzej"],
                        "quantity_unit": "szt",
                        "total_price_gross": agreement["scanspowyzej"] * agreement["cenazascan"] * 1.23,
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
            "kind": "vat",
            "number": invNumber,
            "sell_date": dateFormat(getTodayOrLastDayInMonth(currentPeriodInvoices.period.dateFrom)),
            "issue_date": dateFormat(getTodayOrLastDayInMonth(currentPeriodInvoices.period.dateFrom)),
            "payment_to": dateFormat(addDaysToDate(getTodayOrLastDayInMonth(currentPeriodInvoices.period.dateFrom), invoice['terminplatnosci'])),
            "buyer_name": invoice["nazwapelna"],
            "buyer_tax_no": invoice["nip"],
            "buyer_email": invoice["mailfaktury"],
            "buyer_post_code": invoice["kodpocztowy"],
            "buyer_city": invoice["miasto"],
            "buyer_street": invoice["ulica"],
            "recipient_id": recipient_id || '',
            "positions": positions,
            "show_discount": "0",
            "internal_note": agreementIds.join(','),
            "additional_info": "0",
            "additional_info_desc": "",
            "bank": invoice["bank"],
            "numer_rachunku": invoice["numerrachunku"]
        };
    };

    var normalizeInvNb = function (nb) {
        var nbLength = nb.split('/')[0].toString().length;

        for (var i = nbLength; i < invoice_number_length; i++) {
            nb = '0' + nb;
        }

        return nb;
    };

    var getFormattedDate = function (strDate) {
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
        return [year, month, day].join('-');
    };

    const getTodayOrLastDayInMonth = function (date) {
        const d = new Date(date);
        const dd = new Date(d.getFullYear(), d.getMonth() + 1, 1);
        const today = new Date();
        const lastDayOfMonth = new Date(dd - 1);
        return [lastDayOfMonth, today].reduce((a,b) => a < b ? a:b);
    };

    var dateFormat = function (date) {
        var d = new Date(date);

        return d.toISOString().split('T')[0];
    };

    var addDaysToDate = function (date, days) {
        var d = new Date(date);
        d.setDate(d.getDate() + days);

        return d;
    };


    const updateInvoiceCountStyle = function (key, success) {
        const clientRowClassNameSelector = '.clientRow';

        $(key).removeClass('badge-success');
        $(key).removeClass('badge-danger');
        $(clientRowClassNameSelector).has(key).removeClass('allInvoicesIssued');
        if (success) {
            $(key).addClass('badge-success');
            $(clientRowClassNameSelector).has(key).addClass('allInvoicesIssued');
        } else {
            $(key).addClass('badge-danger');
        }
    };

    $(window).scroll(function (e) {
        var $el = $('.errorMessageWrapper');
        var isPositionFixed = ($el.css('position') == 'fixed');
        if ($(this).scrollTop() > 69 && !isPositionFixed) {
            $('.errorMessageWrapper').css({'position': 'fixed', 'top': '0px'});
        }
        if ($(this).scrollTop() <= 69 && isPositionFixed) {
            $('.errorMessageWrapper').css({'position': 'static', 'top': '0px'});
        }
    });

};