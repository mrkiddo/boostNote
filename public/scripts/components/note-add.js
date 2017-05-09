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
            vm.toggleAdd = function () {
                vm.note = noteService.getBaseModel();
                vm.onToggleAdd();
            };

            vm.addNote = function () {
                noteService.addNote(vm.note).then(function (data) {
                    vm.toggleAdd();
                }, function (err) {
                    // TODO
                });
            };
        };
    },
    controllerAs: 'noteAddCtrl'
};

module.exports = noteAdd;