'use strict';

var noteList = {
    templateUrl: 'http://localhost/boostNote/public/scripts/templates/note-list.html',
    bindings: {
        searchText: '<'
    },
    controller: function noteListController ($scope, $mdToast, noteService) {
        var vm = this;

        vm.$onInit = function () {
            noteService.getNoteData().then(function (data) {
                vm.notes = data;
            }, function (err) {
                // TODO: error handling
            });

            vm.removeNote = function ($event, $index) {
                var toast = $mdToast.simple();
                noteService.deleteNote($index).then(function () {
                    $mdToast.show(toast.textContent('Delete Successfully'));
                }, function () {
                    $mdToast.show(toast.textContent('Oops, delete fails...'));
                });
                $event.stopPropagation();
                $event.preventDefault();
            }
        };

        $scope.$watch(function () {
            return noteService.getNotes();
        }, function () {
            vm.notes = noteService.getNotes();
        });
    },
    controllerAs: 'noteCtrl'
};

module.exports = noteList;
