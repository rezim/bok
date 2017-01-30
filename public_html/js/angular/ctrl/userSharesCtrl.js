UserSharesCtrl = function($scope, rest, $q) {

    $scope.isPending = false;

    var userShares = null;

    this.getUserShares = function() {
        if (!userShares) {
            userShares = {isPending: true};
            rest.post('getusershares').then(function (shares) {
                console.log(shares);
                userShares = shares;
            });
        }

        return userShares;
    };

    this.updatePermission = function(permission, rowid) {
        if (permission != '' && permission != 'r' && permission != 'w' && permission != 'rw') {
            alert("Podałeś błędną wartość, dozwolone to: '', 'r', 'w', 'rw'");
        } else {
            rest.post('updatepermission', {permission: permission, rowid: rowid}).then(function (result) {
                alert(result);
            })
        }
    };

    this.getUserShares();
};

app.controller('UserSharesCtrl', UserSharesCtrl);