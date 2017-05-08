var userService = require('./userService');
var noteService = require('./noteService');

var angular = require('angular');
var app = angular.module('note-app');

app.factory('userService', userService);
app.factory('noteService', noteService);