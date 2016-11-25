app.factory("rest", ['$http', '$q',
    function ($http, $q) { // This service connects to our REST API

        var serviceBase = '';

        var obj = {};
        obj.get = function (q) {
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
            return $http({
                method: 'post',
                url: serviceBase + q + '/notemplate',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                transformRequest: function(obj) {
                    var str = [];
                    for(var p in obj)
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    return str.join("&");
                },
                data: object
            }).then(function (results) {
                return results.data;
            });
        };

        return obj;
    }]);