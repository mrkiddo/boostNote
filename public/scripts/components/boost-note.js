'use strict';

var boostNote = {
    templateUrl: 'http://localhost/boostNote/public/scripts/templates/boost-note.html',
    controller: function boostNoteController (userService, noteService) {
        var vm = this;

        vm.$onInit = function () {
            vm.isSync = false;
            vm.isAdd = false;
            vm.searchText = '';
            vm.userInfo = undefined;

            vm.searchTextChange = function (text) {
                vm.searchText = text;
            };

            vm.signOut = function () {
                userService.signOut();
            };

            vm.toggleAdd = function () {
                vm.isAdd = !vm.isAdd;
            };

            vm.reloadNotes = function () {
                noteService.getNoteData();
            };

            userService.getAuth().then(function (data) {
                vm.userInfo = data;
            }, function (err) {
                // TODO: error handling
            });
        };
    }
};

module.exports = boostNote;