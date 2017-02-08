UserSharesCtrl = function($scope, rest, $q, $sce) {

    $scope.isPending = false;

    $scope.search = {};

    $scope.order = 'roleName';

    $scope.newShare = {
        activity: true
    };

    $scope.lastActionResult = "";

    var userShares = null;

    this.getUserShares = function() {
        if (!userShares) {
            userShares = [];
            userShares.isPending = true;
            rest.post('getusershares').then(function (shares) {
                console.log(shares);
                userShares = shares;
            });
        }

        return userShares;
    };

    var availableRoles = null;

    this.getAvailableRoles = function() {
        if (!availableRoles) {
            availableRoles = [];
            availableRoles.isPending = true;
            rest.post('getroles').then(function(roles) {
                availableRoles = roles;
            })
        }

        return availableRoles;
    };

    this.updatePermission = function(permission, rowid, roleid) {
        if (permission != '' && permission != 'r' && permission != 'w' && permission != 'rw') {
            alert("Podałeś błędną wartość, dozwolone to: '', 'r', 'w', 'rw'");
        } else {
            rest.post('updatepermission', {permission: permission, rowid: rowid, roleid: roleid}).then(function (result) {
                $scope.lastActionResult = result;
                invalidate();
            })
        }
    };

    this.addPermission = function() {
        var newPermission = angular.copy($scope.newShare);
        newPermission.activity = (newPermission.activity) ? 1 : 0;
        rest.post('addpermission', newPermission).then(function(result) {
            $scope.lastActionResult = result;
            invalidate();
        });
    };

    this.removePermission = function(rowid, roleid) {
        rest.post('removepermission', {rowid: rowid, roleid: roleid}).then(function (result) {
            $scope.lastActionResult = result;
            invalidate();
        })
    };

    this.toTrusted = function(text) {
        return $sce.trustAsHtml(text);
    };

    var invalidate = function() {
        userShares = null;
    };

    this.getSelectedRoleName = function(roleRowId) {
        var name = '';
        if (availableRoles && availableRoles.length) {
            var found = availableRoles.find(function(role) {return role.rowid == roleRowId} );
            if (found) {
                name = found.nazwa;
            }
        }

        return name;
    };

    this.getUserShares();

    this.getAvailableRoles();
};

app.controller('UserSharesCtrl', UserSharesCtrl);