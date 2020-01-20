ClientInvoicesCtrl = function($scope, rest, $q, $filter, $uibModal, $interpolate, appConf) {

    $scope.date = new Date();

    $scope.isPending = false;

    $scope.search = {
        name: ""
    };

    $scope.orderBy = {
        propertyName: 'name',
        reverse: false
    };

    $scope.sortBy = function(propertyName) {
        $scope.orderBy.reverse = ($scope.orderBy.propertyName === propertyName) ? !$scope.orderBy.reverse : false;
        $scope.orderBy.propertyName = propertyName;
    };

    $scope.filters = {
        show_paid_invoices: false,
        show_non_deptors: false
    };

    $scope.deptorsOnly = function(disabled) {
        return function(item) {
            return !disabled ? item.invoices.sum.notPaid > 0 : true;
        }
    };

    $scope.notPaidInvoicesOnly = function(disabled) {
        return function(item) {
            return !disabled ? !item.is_paid : true;
        }
    };

    $scope.notPaidInvoices = {
        is_paid: false
    };

    this.show_details = {};

    var date_to = new Date();

    $scope.date_to = $filter('date')(date_to, 'yyyy-MM-dd');

    date_to.setFullYear(date_to.getFullYear()-1);

    $scope.date_from = $filter('date')(date_to, 'yyyy-MM-01');

    const self = this;

    let clientInvoices = [];

    this.getToday = function() {
        return $filter('date')(new Date(), 'yyyy-MM-dd');
    };

    this.getLastMonths = function(months) {
        const today = new Date();
        today.setMonth(today.getMonth() - months);

        return $filter('date')(today, 'yyyy-MM-01');;
    };

    this.getClientInvoices = function() {
        return clientInvoices;
    };

    this.invalidate = function() {
        clientInvoices = [];
    };

    let invoices;

    this.loadData = function(date_from, date_to) {
        if (date_from && date_to) {
            $scope.isPending = true;
            this.invalidate();
            const invoicesPromise = rest.post('getinvoices', {
                period: 'more',
                date_from: date_from,
                date_to: date_to
            });

            const agreementsPromise = rest.post('getagreements', {});

            const overpaidPaymentsPromise = rest.post('getoverpaidpayments', {});

            $q.all([invoicesPromise, agreementsPromise, overpaidPaymentsPromise]).then(result => {
                calculate(result[0], result[1], result[2]);

                $scope.isPending = false;
            });
        }
    };

    const initClientInvoice = function(name, nip) {
        return {
            name: name,
            nip: nip,
            clientId: null,
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
            }
        };
    };

    const calculate = function(invoices, agreements, overpaidpaymets) {
        let objClientInvoice = {};

        angular.forEach(agreements, function (agreement) {

            if (!objClientInvoice[agreement['client_nip']]) {
                objClientInvoice[agreement['client_nip']] =
                    initClientInvoice(agreement['client_name'], agreement['client_nip']);

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
                const day_in_mls = 24*60*60*1000;
                invoice.is_late_days = !invoice.is_paid ?
                    Math.floor(((new Date()) - (new Date(invoice.payment_to))) / day_in_mls) :
                    Math.floor(((new Date(invoice.paid_date)) - (new Date(invoice.payment_to))) / day_in_mls) ;
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

        angular.forEach(objClientInvoice, function(clientInvoice) {
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



        console.log(clientInvoices);
    };

    this.showDetails = function(clientInvoice) {
        this.show_details[clientInvoice.nip] = !this.show_details[clientInvoice.nip];

        // if (!clientInvoice.hasPaymentsLoaded) {
        //     this.loadPaymentsForClientInvoice(clientInvoice);
        //     clientInvoice.hasPaymentsLoaded = true;
        // }
    };

    this.loadPaymentsForClientInvoice = function(clientInvoice) {
        rest.post('getpayments', {
            client_id: clientInvoice.clientId,
            date_from: $scope.date_from
        }).then(function (arrPayments) {
            arrPayments.forEach(function(payment) {
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

    this.paymentsList = function(clientId, clientName, dateFrom, dateTo) {

            let modalInstance = $uibModal.open({
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'paymentList.html',
                size: 'lg',
                controller: function () {
                    this.data = {
                        dateFrom: dateFrom,
                        dateTo: dateTo,
                        clientId: clientId,
                        clientName: clientName
                    };

                    let payments = null;
                    this.getPayments = function (clientId, dateFrom) {
                        if (!payments) {
                            payments = [];
                            rest.post('getpayments', {
                                client_id: clientId,
                                date_from: dateFrom
                            }).then(function (arrPayments) {
                                payments = arrPayments;
                            });
                        }
                        return payments;
                    };

                    this.cancel = function () {
                        modalInstance.dismiss('cancel');
                    };
                },
                controllerAs: '$ctrl'
            });
    };

    this.addPayment = function(clientId, invoiceTaxNo, invoice, callback) {

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

                this.save = function() {
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
            }
        });

        modalInstance.result.then(function (data) {
            rest.post('addinvoicepayment', {
                price: data.form.paid,
                invoice_id: data.invoice.id,
                client_id: data.clientId,
                invoice_tax_no: data.invoiceTaxNo,
                paid_name: data.form.paymentname,
                paid_date: data.form.paymentdate,
                description: data.form.paymentdescription
            }).then(function (payment) {
                console.log(payment);
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
    let mapTaxNo = function(taxNo) {
        let result = taxNo;
        if (result == "8992755868") {
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


    this.loadData($scope.date_from, $scope.date_to);
};

app.controller('ClientInvoicesCtrl', ClientInvoicesCtrl);