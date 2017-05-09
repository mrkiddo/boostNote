'use strict';

var config = require('../config/config');

var noteAdd = {
    templateUrl: config.siteUrl + '/public/scripts/templates/note-add.html',
    bindings: {
        onToggleAdd: '&'
    },
    controller: function noteAddController (noteService) {
        var vm = this;

        vm.note = noteService.getBaseModel();

        vm.$onInit = function () {
            vm.noteContent = '';
        };

        vm.toggleAdd = function () {
            vm.note = noteService.getBaseModel();
            vm.onToggleAdd();
        };
    },
    controllerAs: 'noteAddCtrl'
};

module.exports = noteAdd;