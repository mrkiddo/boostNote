'use strict';

var config = require('../config/config');

var noteAdd = {
    templateUrl: config.siteUrl + '/public/scripts/templates/note-add.html',
    controller: function noteAddController () {
        var vm = this;

        vm.$onInit = function () {
            vm.noteContent = '';
        };
    },
    controllerAs: 'noteAddCtrl'
};

module.exports = noteAdd;