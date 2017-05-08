'use strict';

var userService = function ($q, $http) {
    var userData = {};

    var service = {};

    service.getUserAbbr = function (data) {
        return data.last_name.charAt(0).toUpperCase()
            + data.first_name.charAt(0).toUpperCase();
    };

    service.setUserData = function (data) {
        userData = data;
        userData.user_abbr = this.getUserAbbr(data);
    };

    service.getUserData = function () {
        return userData;
    };

    service.getAuth = function () {
        var self = this;
        return $q(function (resolve, reject) {
            $http({
                method: 'GET',
                url: 'http://localhost/boostNote/user/auth'
            }).then(function (response) {
                self.setUserData(response.data);
                resolve(self.getUserData());
            }, function (err) {
                reject(err);
            });
        });
    };

    service.signOut = function () {
        userData = {};
        location.href = 'http://localhost/boostNote/user/logout';
    };

    return service;
};

module.exports = userService;