ProfitabilityCtrl = function($scope, rest, $q) {

    $scope.isPending = false;

    var profits = [];

    this.getProfits = function() {
        return profits;
    };

    this.loadData = function(date_from, date_to) {
        if (date_from && date_to) {
            $scope.isPending = true;
            profits = [];
            rest.post('getinvoices', {
                period: 'more',
                date_from: date_from,
                date_to: date_to
            }).then(function (invoices) {
                rest.post('getcostsperagreements', {
                    date_from: date_from,
                    date_to: date_to
                }).then(function (costsPerAgreements) {
                    rest.post('getcostsperclients', {
                        date_from: date_from,
                        date_to: date_to
                    }).then(function (costsPerClients) {
                        var objProfits = {};
                        angular.forEach(costsPerClients, function (costs) {
                            if (!objProfits[costs.nip]) {
                                objProfits[costs.nip] = {};
                            }
                            objProfits[costs.nip]['costs'] = costs;

                        });

                        angular.forEach(invoices, function (invoice) {
                            if (!objProfits[invoice.buyer_tax_no]) {
                                objProfits[invoice.buyer_tax_no] = {
                                };
                            }

                            if (!objProfits[invoice.buyer_tax_no]['invoice']) {
                                objProfits[invoice.buyer_tax_no]['invoice'] = {
                                    sum: 0,
                                    nip: invoice.buyer_tax_no
                                }
                            }
                            objProfits[invoice.buyer_tax_no]['invoice']['sum'] += parseFloat(invoice['price_net']);
                        });


                        angular.forEach(costsPerAgreements, function (costs) {
                            if (!objProfits[costs.nip]) {
                                objProfits[costs.nip] = {};
                            }

                            if (!objProfits[costs.nip]['agreements']) {
                                objProfits[costs.nip]['agreements'] = [];
                            }

                            objProfits[costs.nip]['agreements'].push(costs);
                        });


                        angular.forEach(objProfits, function(profit) {
                            profits.push(profit);
                        });

                        $scope.isPending = false;
                    });
                });
            });

        }
    }
};

app.controller('ProfitabilityCtrl', ProfitabilityCtrl);