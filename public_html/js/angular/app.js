var app = angular.module('app', []);

app.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
}]);


app.directive('colorbox', function() {
    return {
        restrict: 'AC',
        link: function (scope, element, attrs) {
            $(element).colorbox({html: attrs.html});
        }
    };
});

app.filter('showProfits', function() {
    return function( profits, show ) {


        var filtered = [];

        for (var i = 0; i < profits.length; i++) {

                var profit = profits[i];

                if ((profit.invoice && profit.invoice.sum != 0) || profit.sum.total != 0) {

                    if (show) {
                        if (profit.invoice && (profit.invoice.sum - profit.sum.total) < 0) {
                            filtered.push(profit);
                        }
                    } else {
                        filtered.push(profit);
                    }

                }
        }
        return filtered;
    };
});

app.filter('showWithCosts', function() {
    return function( profits, show ) {


        var filtered = [];

        for (var i = 0; i < profits.length; i++) {

            var profit = profits[i];

            if (show) {
                if (profit.sum.total > 0) {
                    filtered.push(profit);
                }
            } else {
                filtered.push(profit);
            }

        }
        return filtered;
    };
});

app.filter('sumOfValue', function () {
    return function (data, key1, key2) {
        if (angular.isUndefined(data) && angular.isUndefined(key1) && angular.isUndefined(key2))
            return 0;
        var sum = 0;
        angular.forEach(data,function(value){
            sum += (value[key1]) ? parseFloat(value[key1][key2]) : 0;
        });
        return sum;
    };
});

app.filter('sumOfDifferences', function () {
    return function (data, key1, key2, key3, key4) {
        if (angular.isUndefined(data) && angular.isUndefined(key1) && angular.isUndefined(key2) && angular.isUndefined(key3) && angular.isUndefined(key4))
            return 0;
        var sum = 0;
        angular.forEach(data,function(value){
            var v1 = (value[key1]) ? parseFloat(value[key1][key2]) : 0;
            var v2 = (value[key3]) ? parseFloat(value[key3][key4]) : 0;
            sum += v1-v2;
        });
        return sum;
    };
});