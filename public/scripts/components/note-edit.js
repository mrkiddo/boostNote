'use strict';

var noteEdit = {
    templateUrl: 'public/scripts/templates/note-edit.html',
    bindings: {
        isEdit: '<',
        onToggleEdit :'&'
    },
    controller: function noteEditController ($scope, noteService) {
        var vm = this;

        vm.note = noteService.getBaseModel();

        vm.$onInit = function () {

            vm.toggleEdit = function () {
                vm.onToggleEdit();
            };

            vm.updateNote = function () {
                noteService.updateNote(vm.note);
            };

            vm.onSave = function ($event) {
                vm.updateNote();
                vm.toggleEdit();
                $event.preventDefault();
            };
        };

        $scope.$watch(function () {
            return noteService.getSelectNote();
        }, function (value) {
            vm.note = value;
        });
    },
    controllerAs: 'noteEditCtrl'
};

module.exports = noteEdit;