var boostNoteCom = require('./boost-note');
var navBarCom = require('./nav-bar');
var noteListCom = require('./note-list');
var noteAddCom = require('./note-add');

var angular = require('angular');
var app = angular.module('note-app');

app.component('navBar', navBarCom);
app.component('boostNote', boostNoteCom);
app.component('noteList', noteListCom);
app.component('noteAdd', noteAddCom);
