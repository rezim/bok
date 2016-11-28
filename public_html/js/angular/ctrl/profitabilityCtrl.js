ProfitabilityCtrl = function($scope, rest, $q, $interpolate) {

    $scope.isPending = false;

    $scope.search = {
        name: ""
    };

    var profits = [];

    var invoiceDetails = {};

    this.getProfits = function() {
        return profits;
    };

    this.invalidate = function() {
        profits = [];
        clientInvoices = {};
    };

    this.loadData = function(date_from, date_to) {
        if (date_from && date_to) {
            $scope.isPending = true;
            this.invalidate();
            rest.post('getinvoices', {
                period: 'more',
                date_from: date_from,
                date_to: date_to
            }).then(function (invoices) {
                rest.post('getoveralcosts', {
                    date_from: date_from,
                    date_to: date_to
                }).then(function (overalCosts) {

                    var objProfits = {};

                    angular.forEach(overalCosts, function (costs) {
                        // if client not exists, initialize object with new client
                        if (!objProfits[costs['client_nip']]) {
                            objProfits[costs['client_nip']] = {
                                name: costs['client_name'],
                                nip: costs['client_nip'],
                                agreements: {},
                                sum: {
                                    iloscKm: 0,
                                    czasPracy: 0,
                                    wartoscMaterialow: 0,
                                    total: 0,
                                    wartoscUrzadzen: 0
                                }
                            };
                        }

                        var client = objProfits[costs['client_nip']];
                        // add sums
                        client.sum['iloscKm'] += parseNb(costs['ilosc_km']);
                        client.sum['czasPracy'] += parseNb(costs['czas_pracy']);
                        client.sum['wartoscMaterialow'] += parseNb(costs['wartosc_materialow']);
                        client.sum['wartoscUrzadzen'] += parseNb(costs['client_agreement_value_unit']);
                        client.sum['total'] = client.sum['iloscKm'] + client.sum['czasPracy'] + client.sum['wartoscMaterialow'];

                        // if agreement not exists, add new client agreement
                        if (!client.agreements[costs['client_agreement_id']]) {
                            client.agreements[costs['client_agreement_id']] = {
                                agreementId: costs['client_agreement_id'],
                                agreementRowId: costs['client_agreement_rowid'],
                                agreementIsActive: costs['agreement_isActive'],
                                agreementStartDate: costs['agreement_startDate'],
                                agreementEndDate: costs['agreement_endDate'],
                                agreementValueUnit: costs['client_agreement_value_unit'],
                                devices: {},
                                sum: {
                                    iloscKm: 0,
                                    czasPracy: 0,
                                    wartoscMaterialow: 0,
                                    total: 0
                                }
                            };
                        }
                        var agreement = client.agreements[costs['client_agreement_id']];
                        // add sums
                        agreement.sum['iloscKm'] += parseNb(costs['ilosc_km']);
                        agreement.sum['czasPracy'] += parseNb(costs['czas_pracy']);
                        agreement.sum['wartoscMaterialow'] += parseNb(costs['wartosc_materialow']);
                        agreement.sum['total'] = agreement.sum['iloscKm'] + agreement.sum['czasPracy'] + agreement.sum['wartoscMaterialow'];

                        if (costs['device_sn']) {
                            // if device not exists, add new client agreement device
                            if (!agreement.devices[costs['device_sn']]) {
                                agreement.devices[costs['device_sn']] = {
                                    deviceSN: costs['device_sn'],
                                    iloscKm: parseNb(costs['ilosc_km']),
                                    czasPracy: parseNb(costs['czas_pracy']),
                                    wartoscMaterialow: parseNb(costs['wartosc_materialow']),
                                    total: parseNb(costs['ilosc_km']) + parseNb(costs['czas_pracy']) + parseNb(costs['wartosc_materialow'])
                                };
                            }
                        }
                    });

                    angular.forEach(invoices, function (invoice) {
                        if (!objProfits[invoice.buyer_tax_no]) {
                            objProfits[invoice.buyer_tax_no] = {
                            };
                        }

                        if (!objProfits[invoice.buyer_tax_no]['invoice']) {
                            objProfits[invoice.buyer_tax_no]['invoice'] = {
                                sum: 0,
                                nip: invoice.buyer_tax_no,
                                list: []
                            }
                        }
                        objProfits[invoice.buyer_tax_no]['invoice']['sum'] += parseNb(invoice['price_net']);
                        objProfits[invoice.buyer_tax_no]['invoice'].list.push(invoice);
                    });


                    angular.forEach(objProfits, function(profit) {

                        var tmpAgreements = [];
                        angular.forEach(profit.agreements, function(agreement) {
                            var tmpDevices = [];
                            angular.forEach(agreement.devices, function(device) {
                                tmpDevices.push(device);
                            });
                            agreement.devices = tmpDevices;

                            tmpAgreements.push(agreement);
                        });
                        profit.agreements = tmpAgreements;

                        profits.push(profit);
                    });

                    $scope.isPending = false;

                });
            });

        }
    };

    this.getInvoiceDetails = function(invList, clientId) {
        if (!invoiceDetails[clientId]) {
            var invIds = [];
            angular.forEach(invList, function(inv) {
                invIds.push(inv.id);
            });

            getInvoicesByIds(invIds);
        }
    };

    var getInvoicesByIds = function (ids) {
        // TODO: move it to configuration
        var url = 'https://otus.fakturownia.pl/invoices/{{id}}.json?api_token=kVWaYhlLHXhWQNKDTSk/OTUS';
        var requests = [];
        angular.forEach(ids, function (invId) {
            requests.push(rest.get($interpolate(url, {id: invId})));
        });


        $q.all(requests, function(responses) {
            console.log(responses);
        });
    };

    var parseNb = function(val) {
        val = parseFloat(val);
        
        return isNaN(val) ? 0 : val;
    }
};

app.controller('ProfitabilityCtrl', ProfitabilityCtrl);