ClientInvoicesCtrl = function($scope, rest, $q, $filter, $interpolate, appConf) {

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

    $scope.show_details = {};

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


    this.getNotificationTemplate = function (notification) {
        return $interpolate("<table class='notification-popup' cellspacing='10' cellpadding='5'>" +
            "<tr>" +
            "<td>serial:</td><td>[[serial]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>osoba zgłaszająca:</td><td>[[osobazglaszajaca]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>email:</td><td>[[email]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>nr telefonu:</td><td>[[nr_telefonu]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>temat:</td><td>[[temat]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>treść wiadomości:</td><td class='text-field'>[[tresc_wiadomosci]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>diagnoza:</td><td class='text-field'>[[diagnoza]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>co zrobione:</td><td class='text-field'>[[cozrobione]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>użyte materiały:</td><td>[[uzyte_materialy]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>ilosc km:</td><td>[[ilosc_km]]</td>" +
            "</tr>" +
            "<tr>" +
            "<td>czas pracy:</td><td>[[czas_pracy]]</td>" +
            "</tr>" +
            "</table>")(notification);
    };


    this.getAgreementNotifications = function (date_from, date_to, rowagreement_id) {
        if (!agreementNotifications[rowagreement_id]) {
            agreementNotifications[rowagreement_id] = {isPending: true};
            rest.post('getagreementnotifications', {
                date_from: date_from,
                date_to: date_to,
                rowagreement_id: rowagreement_id
            }).then(function (notifications) {
                agreementNotifications[rowagreement_id] = notifications;
            });
        }

        return agreementNotifications[rowagreement_id];
    };

    var invoices, overalCosts;


    this.loadData = function(date_from, date_to) {
        if (date_from && date_to) {
            $scope.isPending = true;
            this.invalidate();
            rest.post('getinvoices', {
                period: 'more',
                date_from: date_from,
                date_to: date_to
            }).then(function (arrInvoices) {
                rest.post('getagreements', {
                }).then(function (arrAgreements) {


                    calculate(arrInvoices, arrAgreements);

                    $scope.isPending = false;

                });
            });

        }
    };

    this.showInactive = function(show) {
        this.invalidate();
        calculate(invoices, overalCosts, show);
    };

    let calculate = function(invoices, agreements) {
        let objClientInvoice = {};

        angular.forEach(agreements, function (agreement) {

                if (!objClientInvoice[agreement['client_nip']]) {
                    objClientInvoice[agreement['client_nip']] = {
                        name: agreement['client_name'],
                        nip: agreement['client_nip'],
                        agreements: {},
                        invoices: {
                            nip: agreement['client_nip'],
                            sum: {
                                all: 0,
                                notPaid: 0
                            },
                            count: {
                                all: 0,
                                notPaid: 0
                            },
                            list: []
                        }
                    };

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
            if (invoice.kind == 'vat') {
                // you can use it in case of need to see a list of
                // results for particular client

                // if (invoice.buyer_tax_no == '5272718493') {
                //     console.log(invoice);
                // }

                // 8992755868 <- 9141528038 ->
                invoice.buyer_tax_no = mapTaxNo(invoice.buyer_tax_no);

                if (!objClientInvoice[invoice.buyer_tax_no]) {
                    objClientInvoice[invoice.buyer_tax_no] = {
                        name: ['# - (brak umowy)', invoice.buyer_name].join(' '),
                        nip: invoice.buyer_tax_no
                    };
                }

                if (!objClientInvoice[invoice.buyer_tax_no]['invoices']) {
                    objClientInvoice[invoice.buyer_tax_no]['invoices'] = {
                        nip: invoice.buyer_tax_no,
                        sum: {
                            all: 0,
                            notPaid: 0
                        },
                        count: {
                            all: 0,
                            notPaid: 0
                        },
                        list: []
                    }
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

        console.log(clientInvoices);
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