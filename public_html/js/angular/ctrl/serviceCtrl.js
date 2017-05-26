ServiceCtrl = function ($scope, rest, $location, $q, $filter, $timeout, $uibModal, $interpolate, appConf) {
    var self = this;

    $scope.clientsSortBy = 'nazwa';

    $scope.clientsFilter = {};

    $scope.clientData = [
        {
            title: "Nazwa",
            type: "text",
            key: "nazwa:s",
            value: ""
        },
        {
            title: "Ulica",
            type: "text",
            key: "ulica:s",
            value: ""
        },
        {
            title: "Miasto",
            type: "text",
            key: "miasto:s",
            value: ""
        },
        {
            title: "Kod pocztowy",
            type: "text",
            key: "kodpocztowy:s",
            value: ""
        },
        {
            title: "Nip",
            type: "text",
            key: "nip:s",
            value: ""
        },
        {
            title: "Telefon",
            type: "text",
            key: "telefon:s",
            value: ""
        },
        {
            title: "Mail",
            type: "text",
            key: "mail:s",
            value: ""
        },
        {
            title: "Uwagi",
            type: "textarea",
            key: "uwagi:s",
            value: ""
        },
        {
            type: "key",
            key: "rowid_clients:i",
            value: ""
        }
    ];

    $scope.clientData.getValue = function(key) {
        return getValueFromArray($scope.clientData, key);
    };

    $scope.deviceData = [
        {
            title: "Dane zgłoszenia",
            type: "section"
        },
        {
            title: "Numer rewersu",
            type: "text",
            key: "revers_number:s",
            value: "",
            readonly: true
        },
        {
            title: "Dane urządzenia",
            type: "section"
        },
        {
            title: "Model drukarki",
            type: "text",
            key: "modeldrukarki:s",
            value: ""
        },
        {
            title: "Numer seryjny",
            type: "text",
            key: "numerseryjny:s",
            value: ""
        },
        {
            title: "Opis usterki",
            type: "textarea",
            key: "opisusterki:s",
            value: ""
        },
        {
            title: "Potrzebne części",
            type: "textarea",
            key: "potrzebneczesci:s",
            value: "",
            readonly: true
        },
        {
            title: "Uwagi serwisu",
            type: "textarea",
            key: "uwagiserwisu:s",
            value: "",
            readonly: true
        },
        {
            title: "Dane kontaktowe",
            type: "section"
        },
        {
            title: "Osoba kontaktowa",
            type: "text",
            key: "imienazwisko:s",
            value: ""
        },
        {
            title: "Telefon",
            type: "text",
            key: "kontakt_telefon:s",
            value: ""
        },
        {
            title: "Mail",
            type: "text",
            key: "kontakt_mail:s",
            value: ""
        },
        {
            title: "Adres dostawy",
            type: "section"
        },
        {
            title: "Ulica",
            type: "text",
            key: "dostawa_ulica:s",
            value: ""
        },
        {
            title: "Miasto",
            type: "text",
            key: "dostawa_miasto:s",
            value: ""
        },
        {
            title: "Kod pocztowy",
            type: "text",
            key: "dostawa_kodpocztowy:s",
            value: ""
        },
        {
            title: "Szczegóły zlecenia",
            type: "section"
        },
        {
            title: "Status",
            type: "select",
            availableOptions: function() {return self.getStatuses()},
            key: "rowid_status:i",
            value: 1
        },
        {
            title: "Wykonuje",
            type: "select",
            availableOptions: function() {return self.getUsers()},
            key: "rowid_user:i",
            value: -1
        },
        {
            title: "Wartość Materiałów",
            type: "text",
            key: "wartosc_materialow:d",
            value: ""
        },
        {
            title: "Przewidywany czas pracy",
            type: "text",
            key: "przewidywany_czas_pracy:d",
            value: "",
            readonly: true
        },
        {
            title: "Czas Pracy",
            type: "text",
            key: "czas_pracy:d",
            value: "",
            readonly: true
        },
        {
            title: "Szacowany koszt naprawy",
            type: "text",
            key: "estymowany_koszt_naprawy:d",
            value: ""
        },
        {
            title: "Koszt naprawy",
            type: "text",
            key: "koszt_naprawy:d",
            value: ""
        },
        {
            key: "rowid_clients:i",
            value: ""
        },
        {
            type: "key",
            key: "rowid:i",
            value: ""
        }
    ];

    $scope.deviceData.getValue = function(key) {
        return getValueFromArray($scope.deviceData, key);
    };

    this.sameAsClientAddress = function(checked, requestData) {
        var client = arrToJson($scope.clientData);

        var request = $filter('filter')(requestData, {key: 'dostawa_ulica:s'});

        if (request && request.length == 1) {
            request[0].value = (checked) ? client['ulica:s'] : "";
        }

        request = $filter('filter')(requestData, {key: 'dostawa_miasto:s'});

        if (request && request.length == 1) {
            request[0].value = (checked) ? client['miasto:s'] : "";
        }

        request = $filter('filter')(requestData, {key: 'dostawa_kodpocztowy:s'});

        if (request && request.length == 1) {
            request[0].value = (checked) ? client['kodpocztowy:s'] : "";
        }

    };

    this.sameAsClientContact = function(checked, requestData) {
        var client = arrToJson($scope.clientData);

        var request = $filter('filter')(requestData, {key: 'imienazwisko:s'});

        if (request && request.length == 1) {
            request[0].value = (checked) ? client['nazwa:s'] : "";
        }

        request = $filter('filter')(requestData, {key: 'kontakt_telefon:s'});
        if (request && request.length == 1) {
            request[0].value = (checked) ? client['telefon:s'] : "";
        }

        request = $filter('filter')(requestData, {key: 'kontakt_mail:s'});
        if (request && request.length == 1) {
            request[0].value = (checked) ? client['mail:s'] : "";
        }
    };

    $scope.selectedClient = null;

    this.setSelectedClient = function(client) {
        var data = this.getCleanData($scope.clientData);
        $scope.selectedClient = this.setData(data, client);
    };

    this.getCleanData = function(data) {
        var copy = angular.copy(data);

        angular.forEach(copy, function(d) {
            d.value = "";
        });

        return copy;
    };

    var previousMode = null;

    $scope.$watch(function () {
        return $location.path();
    }, function (path) {
        previousMode = self.mode;

        if (path.indexOf('/') == 0) {
            self.mode = path.split('/')[1];
        } else {
            // default value
            self.mode = 'view';
            self.queryString = null;
        }

        onModeChanged(self.mode, previousMode);
    });

    $scope.isPending = false;


    $scope.toPrint = null;

    this.goTo = function(path, refUrl) {
        if (refUrl === undefined && $location.search().refUrl) {
            refUrl = $location.search().refUrl;
        }
        if (refUrl) {
            $location.path('/' + path).search('refUrl', refUrl);
        } else {
            $location.path('/' + path).search('');
        }
    };

    this.goToRefUrl = function() {
        this.goTo($location.search()['refUrl']);
    };

    this.print = function(divName, request) {
        $scope.toPrint = request;
        $scope.toPrint.date = new Date();

        $timeout(function () {
            var printContents = document.getElementById(divName).innerHTML;
            var popupWin = window.open('', '_blank', 'width=800,height=600');
            popupWin.document.open();
            popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="/bok/css/bok.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
            popupWin.document.close();
        }, 0);
    };

    /**
     * deprecated
     */
    this.addNew = function () {
        rest.post('addClient', arrToJson($scope.clientData)).then(function(result) {

            var deviceData = arrToJson($scope.deviceData);
            deviceData['rowid_clients:i'] = result.rowid;
            rest.post('addRequest', deviceData).then(function(result) {

                if (deviceData['rowid_user:i']) {

                    var notifyUser = $filter('filter')(users, {id: deviceData['rowid_user:i']});
                    if (notifyUser.length == 1) {
                        notifyEmployee(notifyUser[0]['mail'], deviceData['modeldrukarki:s'], deviceData['numerseryjny:s'], deviceData['opisusterki:s']);
                    }
                }
                invalidate();
                $location.path('/view');
            });
        });
    };

    this.addNewRequest = function(request, client) {
        var clientData = arrToJson(client);
        var deviceData = arrToJson(request);
        deviceData['rowid_clients:i'] = clientData['rowid_clients:i'];
        rest.post('addRequest', deviceData).then(function(result) {

            if (deviceData['rowid_user:i']) {

                var notifyUser = $filter('filter')(users, {id: deviceData['rowid_user:i']});
                if (notifyUser.length == 1) {
                    notifyEmployee(notifyUser[0]['mail'], deviceData['modeldrukarki:s'], deviceData['numerseryjny:s'], deviceData['opisusterki:s']);
                }
            }
            self.setData($scope.clientData);
            self.setData($scope.deviceData);
            requests = null;
            self.goTo('view', '');
        });

    };

    this.updateRequest = function(request, client) {
        var clientData = arrToJson(client);
        var deviceData = arrToJson(request);
        deviceData['rowid_clients:i'] = clientData['rowid_clients:i'];

        rest.post('updateRequest', deviceData).then(function(result) {
            self.setData($scope.clientData);
            self.setData($scope.deviceData);
            requests = null;
            statusesHistory = {};
            self.goTo('view', '');
        });
    };

    this.addClient = function (clientData, select) {
        rest.post('addClient', arrToJson(clientData)).then(function(result) {
            // invalidate client data
            clients = null;
            if(!select) {
                $location.path('clients');
            } else {
                var values = arrToJson(clientData);
                values['rowid_clients:i'] = result['rowid'];
                self.setData($scope.clientData, values); self.goToRefUrl();
            }
        });
    };

    this.showClients = function () {
        $location.path('/clients');
    };

    this.updateClient = function(clientData, select) {
        rest.post('updateClient', arrToJson(clientData)).then(function(result) {
            // invalidate client data
            clients = null;
            if (!select) {
                $location.path('clients');
            } else {
                self.setData($scope.clientData, arrToJson(clientData)); self.goToRefUrl();
            }
        });
        // invalidate selected client data
        this.selectedClient = null;
    };

    this.edit = function(request) {
        $location.path('/edit');
    };

    this.editClient = function(client) {
        $location.path('/editClient');
    };

    this.cancelAction = function() {
        if (previousMode) {
            $location.path('/' + previousMode);
        }
    };

    this.isCancelAvailable = function() {
        return !!previousMode;
    };

    var onModeChanged = function(current, previous) {
        if (current == 'addNewRequest') {
            self.setData($scope.clientData);
            self.setData($scope.deviceData);
            requests = null;
            $location.path('/addRequest');
        }
    };

    this.setData = function(srcData, values) {
        angular.forEach(srcData, function(data) {
            if(data.key) {
                var key = data.key.split(':')[0];
                var type = data.key.split(':')[1];
                data.value = (values && values[key]) ? values[key] : (values && values[data.key]) ? values[data.key] : "";
                if (type == 'i') {
                    data.value = data.value ? parseInt(data.value) : "";
                }
            }
        });

        return srcData;
    };

    // Popups


    this.openStatusHistory = function(requestData) {
        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'statusHistory.html',
            controller: function () {
                var that = this;
                this.isPending = true;

                this.data = requestData;

                this.getStatusHistory = function() {
                    return self.getStatusHistory(this.data.revers_number, function() {that.isPending = false});
                };

                this.cancel = function () {
                    modalInstance.dismiss('cancel');
                };
            },
            controllerAs: '$ctrl'
        });
    };


    this.openEmailList = function(requestData) {
        var modalEmailList = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'emailList.html',
            size: 'lg',
            controller: function () {
                this.requestData = requestData;

                this.openSendEmail = function (request) {
                    self.openSendEmail(request, invalidateEmails);
                };

                this.openEmail = function (email) {
                    self.openEmail(email, true);
                };

                this.replyEmail = function (email) {
                    var mail = angular.copy(email);
                    mail.temat = 'Re: ' + email.temat;
                    self.openEmail(mail, false, invalidateEmails);
                };

                var invalidateEmails = function() {
                    emails = null;
                };

                var emails = null;
                var emailsCache = [];
                this.getEmails = function (reversNumber) {
                    if (!emails) {
                        emails = [];
                        rest.post('getEmails', {revers_number: reversNumber}).then(function (allEmails) {
                            emails.push.apply(emails, allEmails);
                            emailsCache = [];
                            emailsCache.push.apply(emailsCache, allEmails);
                        });
                    }
                    return emailsCache;
                };

                this.cancel = function () {
                    modalEmailList.dismiss('cancel');
                };
            },
            controllerAs: '$ctrl'
        });

        modalEmailList.result.then(function (data) {
        }, function () {
        });
    };

    this.openEmail = function (mail, readonly, callback) {
        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'myModalContent.html',
            controller: function () {

                this.data =
                    {
                        email: mail.email,
                        temat: mail.temat,
                        tresc_wiadomosci: mail.tresc_wiadomosci,
                        revers_number: mail.revers_number
                    };

                this.readonly = readonly;

                this.send = function() {
                    modalInstance.close(this.data);
                };


                this.cancel = function () {
                    modalInstance.dismiss('cancel');
                };
            },
            controllerAs: '$ctrl'
        });

        if (!mail.wasread) {
            rest.post('setEmailRead', {'rowid:i': mail['rowid'], 'wasread:i': 1}).then(function () {
                mail.wasread = 1;
                requests = null;
            });
        }

        modalInstance.result.then(function (data) {
            rest.post('sendMail', data).then(function () {
                emails = null;
                if (callback) {
                    callback();
                }
            });
        }, function () {
            console.log('dissmissed');
        });
    };

    this.openAddEditClient = function(client) {

        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'addEditClient.html',
            controller: function () {

                this.client = self.setData(angular.copy($scope.clientData), client);

                this.addMode = (!client);

                this.save = function(select) {
                    modalInstance.close({client: this.client, addMode: this.addMode, select: select});
                };

                this.cancel = function () {
                    modalInstance.dismiss('cancel');
                };
            },
            controllerAs: '$ctrl'
        });

        modalInstance.result.then(function (data) {
            if (data.addMode) {
                self.addClient(data.client, data.select);
            } else {
                self.updateClient(data.client, data.select);
            }
            if (!data.select) {
                clients = null;
            }
        }, function () {
            // nop
        });
    };

    this.openSendEmail = function(requestData, callback) {

        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'myModalContent.html',
            controller: function () {

                this.data =
                    {
                        email: requestData.mail,
                        temat: $interpolate(appConf.EMAIL.SERWIS.POTWIERDZENIE_KOSZTORYSU.TEMAT)({numer_rewersu: requestData.revers_number}),
                        tresc_wiadomosci: $interpolate(appConf.EMAIL.SERWIS.POTWIERDZENIE_KOSZTORYSU.TRESC)({koszt_naprawy: requestData.estymowany_koszt_naprawy}),
                        revers_number: requestData.revers_number
                    };

                this.send = function() {
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
            rest.post('sendMail', data).then(function () {
                if (callback) {
                    callback();
                }
            });
        }, function () {
            console.log('dissmissed');
        });
    };

    this.updateList = function(showClosed) {
        requests = null;
        this.getRequests(showClosed);
    };

    var clients = null;
    var clientsCache = [];
    this.getClients = function() {
        if (!clients) {
            clients = [];
            rest.post('getClients').then(function (allClients) {
                clients.push.apply(clients, allClients);
                clientsCache = [];
                clientsCache.push.apply(clientsCache, allClients);
            });
        }

        return clientsCache;
    };

    var users = null;
    this.getUsers = function() {
        if (!users) {
            users = [];
            rest.post('getUsers').then(function (allUsers) {
                users.push.apply(users, allUsers);
            });
        }

        return users;
    };

    var requests = null;
    var requestCache = [];
    this.getRequests = function(showClosed) {
        if (!requests) {
            requests = [];
            rest.post('getRequests', {showClosed: !!showClosed}).then(function (allRequests) {
                requests.push.apply(requests, allRequests);
                requestCache = [];
                requestCache.push.apply(requestCache, allRequests);
            });
        }

        return requestCache;
    };

    var statusesHistory = {};
    this.getStatusHistory = function(revers_number, callback) {
        if (!statusesHistory[revers_number]) {
            statusesHistory[revers_number] = [];
            rest.post('getStatusHistory', {revers_number: revers_number}).then(function (statuses) {
                statusesHistory[revers_number].push.apply(statusesHistory[revers_number], statuses);
                if (callback) {
                    callback();
                }
            });
        } else {
            if (callback) {
                callback();
            }
        }

        return statusesHistory[revers_number];
    };

    var currentUserRequests = null;
    this.getCurrentUserRequests = function() {
        if (!currentUserRequests) {
            currentUserRequests = [];
            rest.post('getCurrentUserRequests').then(function (allRequests) {
                currentUserRequests.push.apply(currentUserRequests, allRequests);
            });
        }

        return currentUserRequests;
    };

    var statuses = null;
    this.getStatuses = function() {
        if (!statuses) {
            statuses = [];
            rest.post('getStatuses').then(function (allStatuses) {
                statuses.push.apply(statuses, allStatuses);
            });
        }

        return statuses;
    };

    var notifyEmployee = function(email, modeldrukarki, numerseryjny, opisusterki) {
        rest.post('notifyEmployee', {mail: email, model: modeldrukarki, numer: numerseryjny, opis: opisusterki});
    };

    var arrToJson = function(arr) {
        var json = {};
        angular.forEach(arr, function(elm) {
            if (elm.key) {
                json[elm.key] = elm.value;
            }
        });
        return json;
    };

    var getValueFromArray = function (dataObj, key) {
        var data = $filter('filter')(dataObj, {key: key});
        return data.length > 0 ? data[0].value : null;
    };

    var invalidate = function() {
        requests = null;
        currentUserRequests = null;
        clients = null;
        self.setData();
    };
};

app.controller('ServiceCtrl', ServiceCtrl);