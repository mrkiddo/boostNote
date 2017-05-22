'use strict';

var noteAdd = {
    templateUrl: 'public/scripts/templates/note-add.html',
    bindings: {
        onToggleAdd: '&'
    },
    controller: function noteAddController ($mdToast, noteService) {
        var vm = this;

        vm.note = noteService.getBaseModel();

        vm.$onInit = function () {
            vm.toggleAdd = function () {
                vm.note = noteService.getBaseModel();
                vm.onToggleAdd();
            };

            vm.addNote = function () {
                var toast = $mdToast.simple();
                noteService.addNote(vm.note).then(function (data) {
                    vm.toggleAdd();
                    $mdToast.show(toast.textContent('Created Successfully'));
                }, function (err) {
                    $mdToast.show(toast.textContent('Oops, creation fails...'));
                });
            };
        };
    },
    controllerAs: 'noteAddCtrl'
};

module.exports = noteAdd;