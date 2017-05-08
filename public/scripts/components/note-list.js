'use strict';

var noteList = {
    templateUrl: 'http://localhost/boostNote/public/scripts/templates/note-list.html',
    bindings: {
        searchText: '<'
    },
    controller: function noteListController ($scope, noteService) {
        var vm = this;

        vm.$onInit = function () {
            noteService.getNoteData().then(function (data) {
                vm.notes = data;
            }, function (err) {
                // TODO: error handling
            });
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
