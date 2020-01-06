ProfitabilityCtrl = function($scope, rest, $q, $filter, $interpolate, appConf) {

    $scope.date = new Date();

    $scope.isPending = false;

    $scope.search = {
        name: ""
    };

    this.device = {
        agreementPrinterModel: ""
    };

    $scope.show_details = {};

    this.show_devices_view = false;

    var date_to = new Date();

    $scope.date_to = $filter('date')(date_to, 'yyyy-MM-01');

    date_to.setMonth(date_to.getMonth()-1);

    $scope.date_from = $filter('date')(date_to, 'yyyy-MM-01');

    this.showLossOnly = false;

    var self = this;

    var profits = [];

    var invoiceDetails = {};

    var agreementNotifications = {};

    this.getToday = function() {
        return $filter('date')(new Date(), 'yyyy-MM-dd');
    };

    this.getProfits = function() {
        return profits;
    };

    this.invalidate = function() {
        profits = [];
        invoiceDetails = {};
        agreementNotifications = {};
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
                rest.post('getoveralcosts', {
                    date_from: date_from,
                    date_to: date_to
                }).then(function (arrOveralCosts) {

                    invoices = arrInvoices;

                    overalCosts = arrOveralCosts;


                    calculate(invoices, overalCosts);

                    $scope.isPending = false;

                });
            });

        }
    };

    this.showInactive = function(show) {
        this.invalidate();
        calculate(invoices, overalCosts, show);
    };

    var calculate = function(invoices, overalCosts, showInactive) {
        var objProfits = {};

        angular.forEach(overalCosts, function (costs) {
            if (costs['agreement_isActive'] || showInactive) {
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
                        agreementPrinterModel: costs['printer_model'],
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
                            deviceModel: costs['device_model'],
                            iloscKm: parseNb(costs['ilosc_km']),
                            czasPracy: parseNb(costs['czas_pracy']),
                            wartoscMaterialow: parseNb(costs['wartosc_materialow']),
                            total: parseNb(costs['ilosc_km']) + parseNb(costs['czas_pracy']) + parseNb(costs['wartosc_materialow'])
                        };
                    }
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

                if (!objProfits[invoice.buyer_tax_no]) {
                    objProfits[invoice.buyer_tax_no] = {};
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
            }
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

            if (profit.invoice) {
                self.getInvoiceDetails(profit.invoice.list, profit.nip, function(invoiceDetails) {

                    profit.agreements.forEach(function(agreement) {
                        if (invoiceDetails[agreement.agreementRowId]) {
                            agreement['netPrice'] = invoiceDetails[agreement.agreementRowId].netPrice;

                            console.log(agreement);
                        }
                    });


                });
            }

            profits.push(profit);
        });
    };

    this.getAgreements = function (modelFilter) {
        var agreements = [];
        profits.forEach(function(profit) {
            agreements = agreements.concat($filter('filter')(profit.agreements, modelFilter));
        });

        return agreements;
    };

    this.getInvoiceDetails = function(invList, clientId, callback) {
        if (!invoiceDetails[clientId]) {
            var invIds = [];
            angular.forEach(invList, function(inv) {
                invIds.push(inv.id);
            });

            invoiceDetails[clientId] = {isPending: true};

            getInvoicesByIds(invIds, clientId, callback);
        }

        return invoiceDetails[clientId];
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
    var mapTaxNo = function(taxNo) {
        var result = taxNo;
        if (result == "8992755868") {
            result = "9141528038";
        }

        return result;
    };

    this.getDate = function (strDate) {
        var result = strDate;
        if (strDate && strDate.split(' ').length > 1) {
            result = strDate.split(' ')[0];
        }

        return result;
    };

    var getInvoicesByIds = function (ids, clientId, callback) {
        // TODO: move it to configuration
        var url = appConf.ENDPOINT + '/invoices/{id}.json?api_token=' + appConf.API_TOKEN;
        var requests = [];
        angular.forEach(ids, function (invId) {
            requests.push(rest.get(url.replace('{id}',invId)));
        });


        $q.all(requests).then(function(responses) {
            var result = {};
            angular.forEach(responses, function(response) {
                result = mergeParsedInvoices(result, parseInvoice(response));
            });
            invoiceDetails[clientId] = result;

            if (callback) {
                callback(invoiceDetails[clientId]);
            }
        });
    };


    var mergeParsedInvoices = function(inv1, inv2) {
        var result = inv1;
        angular.forEach(inv2, function(value, key) {
            if (result[key]) {
                result[key].netPrice += value.netPrice;
            } else {
                result[key] = inv2[key];
            }
        });

        return result;
    };

    var parseInvoice = function(invoice) {
        var agreements, positions;
        var parsedInvoice = {};
        if (invoice.internal_note) {
            agreements = getOrderedAgreements(invoice.internal_note);
            positions = parseInvoicePositions(invoice.positions);

            if (!(agreements.length == positions.length)) {
                console.log("Error for invoice: " + invoice);
            } else {
                for(var i=0; i<agreements.length; i++) {
                    var agreement = agreements[i];
                    var position = positions[i];
                    parsedInvoice[agreement] = {
                        device: position.name,
                        netPrice: position.sum,
                        agreementNb: agreement
                    };
                }
            }
        } else {
            console.log("Warning! no agreements for invoice: " + [invoice.buyer_name, invoice.id, invoice.token].join('-'));
        }

        return parsedInvoice;
    };

    var parseInvoicePositions = function(positions) {
        var devices = [];
        var currentElement;
        angular.forEach(positions, function(position) {
            var newDeviceName;
            if (position.name.startsWith('Wynajem drukarki')) {
                newDeviceName = position.name.split('Wynajem drukarki ')[1];
                currentElement = {name: newDeviceName, sum: parseFloat(position.total_price_net)};
                devices.push(currentElement);
            } else if (position.name.startsWith('Wynajem niszczarki')) {
                newDeviceName = position.name.split('Wynajem niszczarki ')[1];
                    currentElement = {name: newDeviceName, sum: parseFloat(position.total_price_net)};
                    devices.push(currentElement);
            } else if (position.name.startsWith('Wynajem urządzenia')) {
                newDeviceName = position.name.split('Wynajem urządzenia ')[1];
                currentElement = {name: newDeviceName, sum: parseFloat(position.total_price_net)};
                devices.push(currentElement);
            } else {
                currentElement.sum += parseFloat(position.total_price_net);
            }
        });

        return devices;
    };

    var getOrderedAgreements = function(strAgreements) {
        var agrNbs = strAgreements.split(',');

        return agrNbs.sort(function(a, b) {
            var aa = a.split('/');
            var bb = b.split('/');

            var result = 0, i = 2;

            do {
                result = parseInt(aa[i]) - parseInt(bb[i]);
                i--;
            } while(result == 0 && i >= 0);

            return result;
        });
    };

    var parseNb = function(val) {
        val = parseFloat(val);
        
        return isNaN(val) ? 0 : val;
    };


    this.loadData($scope.date_from, $scope.date_to);
};

app.controller('ProfitabilityCtrl', ProfitabilityCtrl);