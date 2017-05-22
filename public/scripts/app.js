'use strict';

var angular = require('angular');
var angularMaterial = require('angular-material');

var app = angular.module('note-app', [angularMaterial]);

app.config(function ($httpProvider, $mdThemingProvider) {
    $httpProvider.defaults.headers.post = {
        'Content-type': 'application/x-www-form-urlencoded'
    };
    $httpProvider.defaults.transformRequest = function (data) {
        if(data === undefined) {
            return data;
        }
        var str = [];
        for(var p in data) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(data[p]));
        }
        return str.join("&");
    };

    $mdThemingProvider.theme('default')
        .primaryPalette('green', {
            'default': '500',
            'hue-1': '100',
            'hue-2': '200',
            'hue-3': '300'
        })
        .accentPalette('green', {
            'default': '200'
        });
});


var configs = require('./config');
var components = require('./components');
var services = require('./services');