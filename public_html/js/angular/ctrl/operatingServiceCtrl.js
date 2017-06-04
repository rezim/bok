OperatingServiceCtrl = function ($scope, rest, $location, $q, $filter, $timeout, $uibModal) {
    var self = this;

    $scope.deviceData = [
        {
            title: "Model drukarki",
            type: "text",
            key: "modeldrukarki:s",
            value: "",
            readonly: true
        },
        {
            title: "Numer seryjny",
            type: "text",
            key: "numerseryjny:s",
            value: "",
            readonly: true
        },
        {
            title: "Opis usterki",
            type: "textarea",
            key: "opisusterki:s",
            value: "",
            readonly: true
        },
        {
            title: "Potrzebne części",
            type: "textarea",
            key: "potrzebneczesci:s",
            value: ""
        },
        {
            title: "Uwagi serwisu",
            type: "textarea",
            key: "uwagiserwisu:s",
            value: ""
        },
        {
            title: "Status",
            type: "select",
            availableOptions: function() {
                return self.getStatuses(this.value);
            },
            key: "rowid_status:i",
            value: 1
        },
        {
            title: "Przewidywany czas pracy",
            type: "time",
            key: "przewidywany_czas_pracy:d",
            value: 0.00,
            hide: function() {
                var dData = arrToJson($scope.deviceData);
                return (dData['rowid_status:i'] > 3);
            }
        },
        {
            title: "Czas Pracy",
            type: "time",
            key: "czas_pracy:d",
            value: 0.00,
            hide: function() {
                var dData = arrToJson($scope.deviceData);
                return (dData['rowid_status:i'] < 4);
            }
        },
        {
            type: "key",
            key: "rowid:i",
            value: ""
        }
    ];


    this.errorMessage = "";

    $scope.deviceData.getValue = function(key) {
        return getValueFromArray($scope.deviceData, key);
    };

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

    this.updateRequest = function(request) {
        rest.post('serviceUpdateStatus', arrToJson(request)).then(function (result) {
            invalidate();
        });
    };

    this.edit = function(request) {
        setData(request, 'rowid');

        // invalidate statuses before getting new set of available
        statuses = null;
        this.getStatuses(request.rowid_status);

        $location.path('/edit');
    };

    this.openUpdateRequest = function(request) {

        statuses = null;
        this.getStatuses(request.rowid_status);

        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modifyRequest.html',
            size: 'lg',
            controller: function () {

                this.form = {};

                this.request = self.setData($scope.deviceData, request);

                this.updateRequest = function() {

                    if (getValueFromArray(this.request, 'rowid_status:i') == 3 && !(parseFloat(getValueFromArray(this.request, 'przewidywany_czas_pracy:d')) > 0)) {
                        this.form.updateRequest['przewidywany_czas_pracy:d'].$error['notZero'] = true;
                        this.form.updateRequest['przewidywany_czas_pracy:d'].$valid = false;
                        this.form.updateRequest.$valid = false;
                    }

                    if (getValueFromArray(this.request, 'rowid_status:i') == 9 && !(parseFloat(getValueFromArray(this.request, 'czas_pracy:d')) > 0)) {
                        this.form.updateRequest['czas_pracy:d'].$error['notZero'] = true;
                        this.form.updateRequest['czas_pracy:d'].$valid = false;
                        this.form.updateRequest.$valid = false;
                    }

                    if (this.form.updateRequest.$valid) {
                        modalInstance.close({request: this.request});
                    }
                };

                this.cancel = function () {
                    modalInstance.dismiss('cancel');
                };
            },
            bindToController: true,
            controllerAs: '$ctrl'
        });

        modalInstance.result.then(function (data) {
            self.updateRequest(data.request);
        }, function () {
            // nop
        });
    };

    var onModeChanged = function(current, previous) {
        if (current == 'add') {
            // setData();
        }

        if (current == 'edit') {
            if (!previous) {
                self.goTo('view');
            }
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
                } else if (type == 'd') {
                    data.value = data.value ? parseFloat(data.value) : 0.00;
                }
            }
        });

        return srcData;
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
    this.getStatuses = function(currentStatus) {
        if (!statuses) {
            statuses = [];

            var availableStatuses = [];

            rest.post('getServiceAvailableStatuses').then(function (allStatuses) {
                allStatuses.forEach(function(status) {
                    if (currentStatus === undefined) {
                        statuses.push(status);
                    } else {
                        if (status.id >= currentStatus -1 && status.id <= currentStatus + 1) {
                            statuses.push(status);
                        }
                    }
                });
            });

        }

        return statuses;
    };

    var notifyEmployee = function(email, modeldrukarki, numerseryjny, opisusterki) {
        rest.post('notifyEmployee', {mail: email, model: modeldrukarki, numer: numerseryjny, opis: opisusterki});
    };

    var getValueFromArray = function (dataObj, key) {
        var data = $filter('filter')(dataObj, {key: key}, true);
        return data.length > 0 ? data[0].value : null;
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