ServiceCtrl = function ($scope, rest, $location, $q, $filter, $timeout) {
    var self = this;

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
            title: "Osoba kontaktowa",
            type: "text",
            key: "imienazwisko:s",
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
            type: "key",
            key: "rowid_clients:i",
            value: ""
        }
    ];

    $scope.deviceData = [
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
            title: "Uwagi klienta",
            type: "textarea",
            key: "uwagiklienta:s",
            value: ""
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
            value: 1
        },
        {
            title: "Wartość Materiałów",
            type: "text",
            key: "wartosc_materialow:d",
            value: ""
        },
        {
            title: "Czas Pracy",
            type: "text",
            key: "czas_pracy:d",
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


    $scope.$watch(function () {
        return $location.path();
    }, function (path) {

        var previousMode = self.mode;

        if (path.indexOf('/') == 0) {
            self.mode = path.split('/')[1];
        } else {
            // default value
            self.mode = 'view';
        }

        onModeChanged(self.mode, previousMode);
    });

    $scope.isPending = false;


    $scope.toPrint = null;

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

    this.updateClient = function() {
        rest.post('updateClient', arrToJson($scope.clientData)).then(function(result) {

            console.log(result);
            invalidate();
            $location.path('/view');
        });
    };

    this.updateRequest = function() {
        rest.post('updateRequest', arrToJson($scope.deviceData)).then(function(result) {

            console.log(result);
            invalidate();
            $location.path('/view');
        });
    };

    this.edit = function(request) {
        setData(request, 'rowid_clients');

        $location.path('/edit');
    };

    var onModeChanged = function(current, previous) {
        if (current == 'add') {
            // setData();
        }
    };

    var setData = function(request) {
        angular.forEach($scope.clientData, function(data) {
            var key = data.key.split(':')[0];
            var type = data.key.split(':')[1];
            data.value = (request && request[key]) ? request[key] : "";
            if (type == 'i') {
                data.value = parseInt(data.value);
            }
        });

        angular.forEach($scope.deviceData, function(data) {
            var key = data.key.split(':')[0];
            data.value = (request && request[key]) ? request[key] : "";
        });
    };

    var clients = null;
    this.getClients = function() {
        if (!clients) {
            clients = [];
            rest.post('getClients').then(function (allClients) {
                clients.push.apply(clients, allClients);
            });
        }

        return clients;
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
    this.getRequests = function() {
        if (!requests) {
            requests = [];
            rest.post('getRequests').then(function (allRequests) {
                requests.push.apply(requests, allRequests);
            });
        }

        return requests;
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
            json[elm.key] = elm.value;
        });
        return json;
    };

    var invalidate = function() {
        requests = null;
        currentUserRequests = null;
        clients = null;
    };
};

app.controller('ServiceCtrl', ServiceCtrl);