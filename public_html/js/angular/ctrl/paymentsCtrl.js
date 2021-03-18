PaymentsCtrl = function ($scope, rest, $q, $filter, $uibModal, $interpolate, appConf) {

    $scope.date = new Date();

    $scope.isPending = false;

    $scope.search = {
        name: ""
    };

    $scope.orderBy = {
        propertyName: 'invoices.count.notPaid',
        reverse: true
    };

    $scope.sortBy = function (propertyName) {
        $scope.orderBy.reverse = ($scope.orderBy.propertyName === propertyName) ? !$scope.orderBy.reverse : false;
        $scope.orderBy.propertyName = propertyName;
    };

    this.filters = {
        show_paid_invoices: true,
        show_overpaid_invoices: true,
        show_non_deptors: false,
        invoiceNb: ''
    };

    this.moreThenOneNotPaidFilter = function () {
        return function (item) {
            return item.invoices.count.notPaid >= 2;
        }
    };

    this.clientInvoicesFilter = function () {

        return function (item) {

            if (self.filters.invoiceNb !== '') {
                if (item.invoices.list.some(
                    function (invoice) {
                        return invoice.number.indexOf(self.filters.invoiceNb) !== -1
                    }
                )
                ) {
                    return true;
                } else {
                    return false;
                }
            }
            if (self.filters.show_overpaid_invoices && item.overpaid.sum > 0) {
                return true;
            }
            if (self.filters.show_non_deptors || item.invoices.sum.notPaid > 0) {
                return true;
            }

            return false;
        }
    };

    this.notPaidInvoicesOnlyFilter = function () {
        return function (item) {
            return !self.filters.show_paid_invoices ? !item.is_paid : true;
        }
    };

    this.show_details = {};

    var date_to = new Date();

    $scope.date_to = $filter('date')(date_to, 'yyyy-MM-dd');

    date_to.setFullYear(date_to.getFullYear() - 1);

    $scope.date_from = $filter('date')(date_to, 'yyyy-MM-01');

    const self = this;

    let clientInvoices = [];

    this.getToday = function () {
        return $filter('date')(new Date(), 'yyyy-MM-dd');
    };

    this.getLastMonths = function (months) {
        const today = new Date();
        today.setMonth(today.getMonth() - months);

        return $filter('date')(today, 'yyyy-MM-01');
        ;
    };

    this.getClientInvoices = function () {
        return clientInvoices;
    };


    this.getTotal = function (search, showPaidInvoices, showNonDeptors) {
        let total = 0;

        let filteredClientInvoices = ($filter('filter')($filter('filter')(clientInvoices, search), this.clientInvoicesFilter()));

        filteredClientInvoices.forEach(clientInvoice => {
            total += parseFloat(clientInvoice.balance);
        });

        return total;
    };

    this.invalidate = function () {
        clientInvoices = [];
    };

    let invoices;

    this.loadData = function (date_from, date_to, notPaidInvoicesOnly) {
        if (date_from && date_to) {
            $scope.isPending = true;
            const serviceName = !notPaidInvoicesOnly ? 'getinvoices' : 'getnotpaidinvoices';
            const invoicesPromise =
                rest.post(serviceName, {
                    period: 'more',
                    date_from: date_from,
                    date_to: date_to
                })

            const agreementsPromise = rest.post('getagreements', {});

            const overpaidPaymentsPromise = !notPaidInvoicesOnly ? rest.post('getoverpaidpayments', {}) : [];

            $q.all([invoicesPromise, agreementsPromise, overpaidPaymentsPromise]).then(result => {

                self.invalidate();

                calculate(result[0], result[1], result[2]);

                $scope.isPending = false;
            });
        }
    };

    const initClientInvoice = function (name, nip, phone, id) {
        return {
            name,
            nip,
            phone,
            clientId: id,
            agreements: {},
            invoices: {
                nip: nip,
                sum: {
                    all: 0,
                    notPaid: 0
                },
                count: {
                    all: 0,
                    notPaid: 0
                },
                list: []
            },
            overpaid: {
                sum: 0,
                list: []
            },
            balance: 0
        };
    };

    const calculate = function (invoices, agreements, overpaidpaymets) {
        let objClientInvoice = {};

        angular.forEach(agreements, function (agreement) {

            if (!objClientInvoice[agreement['client_nip']]) {
                objClientInvoice[agreement['client_nip']] =
                    initClientInvoice(agreement['client_name'], agreement['client_nip'], agreement['client_phone'], agreement['client_id']);

                let client = objClientInvoice[agreement['client_nip']];

                // if agreement not exists, add new client agreement
                if (!client.agreements[agreement['agreement_id']]) {
                    client.agreements[agreement['agreement_id']] = {
                        agreementId: agreement['agreement_id'],
                        agreementRowId: agreement['agreement_rowid'],
                        agreementPaymentDate: agreement['agreement_paymentdate']
                    };
                }


            }
        });

        angular.forEach(invoices, function (invoice) {
            if (invoice.kind == 'vat' || invoice.kind == 'correction') {

                // 8992755868 <- 9141528038 ->
                invoice.buyer_tax_no = mapTaxNo(invoice.buyer_tax_no);

                if (!objClientInvoice[invoice.buyer_tax_no]) {
                    const noAgreementClientName = ['# - (brak umowy)', invoice.buyer_name].join(' ');
                    objClientInvoice[invoice.buyer_tax_no] =
                        initClientInvoice(noAgreementClientName, invoice.buyer_tax_no);
                }

                if (!objClientInvoice[invoice.buyer_tax_no].clientId) {
                    objClientInvoice[invoice.buyer_tax_no].clientId = invoice.client_id;
                }

                invoice.is_paid = parseFloat(invoice.paid) >= parseFloat(invoice.price_gross);
                invoice.is_partially_paid = !invoice.is_paid && (parseFloat(invoice.paid) > 0);
                // if not paid late is today - paid_to, if paid paid_date - paid_to
                const day_in_mls = 24 * 60 * 60 * 1000;
                invoice.is_late_days = !invoice.is_paid ?
                    Math.floor(((new Date()) - (new Date(invoice.payment_to))) / day_in_mls) :
                    Math.floor(((new Date(invoice.paid_date)) - (new Date(invoice.payment_to))) / day_in_mls);
                // there is no late
                if (invoice.is_late_days < 0) {
                    invoice.is_late_days = 0;
                }

                objClientInvoice[invoice.buyer_tax_no]['invoices'].sum.all += parseFloat(invoice.price_gross);
                objClientInvoice[invoice.buyer_tax_no]['invoices'].count.all++;
                if (!invoice.is_paid) {
                    objClientInvoice[invoice.buyer_tax_no]['invoices'].sum.notPaid +=
                        parseFloat(invoice.price_gross) - parseFloat(invoice.paid);
                    objClientInvoice[invoice.buyer_tax_no]['invoices'].count.notPaid++;
                }
                objClientInvoice[invoice.buyer_tax_no]['invoices'].list.push(invoice);
            }
        });

        angular.forEach(objClientInvoice, function (clientInvoice) {
            clientInvoices.push(clientInvoice);
        });

        angular.forEach(overpaidpaymets, function (payment) {
            let clientInvoice = null;
            if (payment.invoice_tax_no) {
                clientInvoice = objClientInvoice[payment.invoice_tax_no];
            } else if (payment.client_id) {
                clientInvoice = clientInvoices.find(clientInv => clientInv.clientId === payment.client_id);
            } else {
                console.log('Nie można powiązać płatności ' + payment.id + ' z zadna fakturą.');
            }

            if (clientInvoice) {
                clientInvoice.overpaid.list.push(payment);
                clientInvoice.overpaid.sum += parseFloat(payment.overpaid);
            }
        });

        clientInvoices.forEach(clientInvoice => {
            clientInvoice.balance = clientInvoice.overpaid.sum - clientInvoice.invoices.sum.notPaid;
        });
    };

    this.showDetails = function (clientInvoice) {
        this.show_details[clientInvoice.nip] = !this.show_details[clientInvoice.nip];

        // if (!clientInvoice.hasPaymentsLoaded) {
        //     this.loadPaymentsForClientInvoice(clientInvoice);
        //     clientInvoice.hasPaymentsLoaded = true;
        // }
    };

    this.loadPaymentsForClientInvoice = function (clientInvoice) {
        rest.post('getpayments', {
            client_id: clientInvoice.clientId,
            date_from: $scope.date_from
        }).then(function (arrPayments) {
            arrPayments.forEach(function (payment) {
                let invoice = clientInvoice.invoices.list.find(inv => inv.id === payment.invoice_id);
                if (invoice) {
                    if (!invoice.payments) {
                        invoice.payments = [];
                    }
                    invoice.payments.push(payment);
                }
            })
        });
    };

    this.paymentsClientMessages = function (clientInvoice) {
        let modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'paymentsClientMessages.html',
            size: 'xl',
            controller: function () {
                this.data = {
                    clientNip: clientInvoice.nip,
                    clientName: clientInvoice.name,
                    form: {
                        date: self.getToday(),
                        message: ''
                    }
                };

                let messages = null;
                this.getMessages = function (nip) {
                    if (!messages) {
                        messages = rest.post('getpaymentclientmessages', {
                            client_nip: nip
                        }).then(function (result) {
                            messages = result;
                        });
                    }

                    return messages;
                };

                this.removeMessage = function (rowid) {
                    if (confirm("Czy na pewno usnąć wiadomość?")) {
                        rest.post('removeclientmessage', {rowid})
                            .then(function () {
                                const removedIndex = messages.findIndex((message) => message.rowid === rowid);
                                if (removedIndex !== -1) {
                                    messages.splice(removedIndex, 1);
                                }
                            });
                    }
                };

                this.save = function () {
                    rest.post('addpaymentclientmessage', {
                        client_nip: this.data.clientNip,
                        message_date: this.data.form.date,
                        message: this.data.form.message
                    }).then(function (message) {
                        messages = message.concat(messages);
                    });
                };

                this.cancel = function () {
                    modalInstance.dismiss('cancel');
                };
            },
            controllerAs: '$ctrl',
            windowClass: 'show',
            backdropClass: 'show'
        });
    };

    this.paymentsList = function (clientInvoice, dateFrom, dateTo) {

        let invalidateListOfInvoices = false;

        let modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'paymentList.html',
            size: 'lg',
            controller: function () {

                this.data = {
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    clientId: clientInvoice.clientId,
                    clientName: clientInvoice.name
                };

                this.parseDate = function (dateStr) {
                    return new Date(dateStr);
                };

                let payments = null;
                this.getPayments = function (clientId, dateFrom) {
                    if (!payments) {
                        payments = [];
                        rest.post('getpayments', {
                            client_id: clientId,
                            date_from: dateFrom
                        }).then(function (arrPayments) {
                            payments = arrPayments.map(payment =>
                                Object.assign(payment, {
                                    invoice: clientInvoice.invoices.list.find(
                                        invoice => payment.invoice_id === invoice.id
                                    )
                                })
                            );
                            // add also overpaid payments to the list
                            const overpaidPayments = clientInvoice.overpaid.list.map(payment =>
                                Object.assign(payment, {
                                    invoice: clientInvoice.invoices.list.find(
                                        invoice => payment.invoice_id === invoice.id
                                    )
                                })
                            );
                            overpaidPayments.forEach(overpaidPayment => {
                                // without duplicates
                                if (!payments.some(payment => payment.id === overpaidPayment.id)) {
                                    payments.push(overpaidPayment);
                                }
                            });
                        });
                    }
                    return payments;
                };

                this.deletePayment = function (paymentId) {
                    rest.post('deleteinvoicepayment', {
                        payment_id: paymentId
                    }).then(() => {
                        const removedIdx = payments.findIndex(payment => payment.id === paymentId);

                        if (removedIdx !== -1) {
                            payments.splice(removedIdx, 1);
                        }

                        invalidateListOfInvoices = true;
                    });
                };

                this.cancel = function () {
                    modalInstance.dismiss('cancel');
                    if (invalidateListOfInvoices) {
                        invalidateListOfInvoices = false;
                        self.loadData($scope.date_from, $scope.date_to);
                    }
                };
            },
            controllerAs: '$ctrl',
            windowClass: 'show',
            backdropClass: 'show'
        });

        modalInstance.result.then(function () {
        }, function () {
            if (invalidateListOfInvoices) {
                invalidateListOfInvoices = false;
                self.loadData($scope.date_from, $scope.date_to);
            }
        });
    };

    this.splitPayments = function (clientId) {
        rest.post('splitclientpayments', {
            client_id: clientId
        }).then(() => {
            self.loadData($scope.date_from, $scope.date_to);
        });
    };

    this.addPayment = function (clientId, invoiceTaxNo, invoice) {

        let modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'addPayment.html',
            size: 'md',
            controller: function () {

                this.data = {
                    clientId: clientId,
                    invoiceTaxNo: invoiceTaxNo,
                    invoice: invoice,
                    form: {
                        paid: (invoice.price_gross - invoice.paid).toFixed(2),
                        paymentname: "Płatność za FV numer " + invoice.number,
                        paymentdate: self.getToday()
                    }
                };

                this.save = function () {
                    modalInstance.close(this.data);
                };

                this.cancel = function () {
                    modalInstance.dismiss('cancel');
                };
            },
            controllerAs: '$ctrl',
            resolve: {
                items: function () {
                    return [];
                }
            },
            windowClass: 'show',
            backdropClass: 'show'
        });

        modalInstance.result.then(function (data) {
            rest.post('addinvoicepayment', {
                price: data.form.paid,
                invoice_id: data.invoice.id,
                client_id: data.clientId,
                invoice_tax_no: data.invoiceTaxNo,
                paid_name: data.form.paymentname,
                paid_date: data.form.paymentdate
            }).then(function (payment) {
                self.loadData($scope.date_from, $scope.date_to);
            });

        }, function () {
            // nop
        });
    };


    /**
     * Currently we need to map NIP for only one client,
     * in case there will be another client, we would need
     * to extend this solution.
     *
     * 8992755868 <- 9141528038
     *
     * @param taxNo
     * @returns {*}
     */
    let mapTaxNo = function (taxNo) {
        let result = taxNo;
        if (result === "8992755868") {
            result = "9141528038";
        }

        return result;
    };

    this.getDate = function (strDate) {
        let result = strDate;
        if (strDate && strDate.split(' ').length > 1) {
            result = strDate.split(' ')[0];
        }

        return result;
    };


    this.showClientCard = function (clientId) {
        showNewClientAdd(clientId);
    }

    // this.loadData($scope.date_from, $scope.date_to);
};

app.controller('PaymentsCtrl', PaymentsCtrl);