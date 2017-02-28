ServiceCtrl = function ($scope, rest, $location, $q, $filter) {
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
            value: ""
        },
        {
            key: "rowid_clients:i",
            value: ""
        }
    ];


    $scope.$watch(function () {
        return $location.path();
    }, function (path) {
        if (path.indexOf('/') == 0) {
            self.mode = path.split('/')[1];
        } else {
            // default value
            self.mode = 'view';
        }
    });

    $scope.isPending = false;

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
        clients = null;
    };
};

app.controller('ServiceCtrl', ServiceCtrl);