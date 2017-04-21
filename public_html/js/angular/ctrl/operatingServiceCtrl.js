OperatingServiceCtrl = function ($scope, rest, $location, $q, $filter, $timeout) {
    var self = this;

    $scope.deviceData = [
        {
            title: "Model drukarki",
            type: "text",
            key: "modeldrukarki:s",
            value: "Minolta"
        },
        {
            title: "Numer seryjny",
            type: "text",
            key: "numerseryjny:s",
            value: "ASD1234567"
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
            value: "Bez Uwag"
        },
        {
            title: "Status",
            type: "select",
            availableOptions: function() {return self.getStatuses()},
            key: "rowid_status:i",
            value: 1
        },
        {
            title: "Wartość Materiałów",
            type: "text",
            key: "wartosc_materialow:d",
            value: "0.01"
        },
        {
            title: "Czas Pracy",
            type: "text",
            key: "czas_pracy:d",
            value: "0.01"
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

    this.updateRequest = function() {
        rest.post('updateRequest', arrToJson($scope.deviceData)).then(function(result) {

            console.log(result);
            invalidate();
            $location.path('/view');
        });
    };

    this.edit = function(request) {
        setData(request, 'rowid');

        $location.path('/edit');
    };

    var onModeChanged = function(current, previous) {
        if (current == 'add') {
            // setData();
        }
    };

    var setData = function(request) {
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
            rest.post('getServiceAvailableStatuses').then(function (allStatuses) {
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

app.controller('OperatingServiceCtrl', OperatingServiceCtrl);