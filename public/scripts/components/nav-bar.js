'use strict';

var navBar = {
    templateUrl: 'http://localhost/boostNote/public/scripts/templates/nav-bar.html',
    bindings: {
        isSync: '<',
        isAdd: '<',
        userInfo: '<',
        onSearchChange: '&',
        onSignOut: '&',
        onReloadNotes: '&',
        onToggleAdd: '&'
    },
    controller: function navBarController () {
        var vm = this;
        var originatorEv;
        vm.searchText = '';

        vm.searchUpdate = function () {
            vm.onSearchChange({text: vm.searchText});
        };

        vm.searchReset = function () {
            vm.searchText = '';
            vm.searchUpdate();
        };

        vm.openMenu = function ($mdMenu, ev) {
            originatorEv = ev;
            $mdMenu.open(ev);
        };

        vm.signOut = function () {
            vm.onSignOut();
        };

        vm.toggleAdd = function () {
            vm.onToggleAdd();
        };

        vm.reloadNotes = function ($event) {
            vm.onReloadNotes();
            $event.stopPropagation();
        }
    },
    controllerAs: 'navCtrl'
};

module.exports = navBar;