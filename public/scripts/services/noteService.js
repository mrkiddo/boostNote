'use strict';

var noteService = function ($q, $http) {
    var noteData = [];

    var service = {};

    service.getNotes = function () {
        return noteData;
    };

    service.setNotes = function (data) {
        noteData = data;
    };

    service.deleteNote = function (index) {
        noteData.splice(index, 1);
    };

    service.addNote = function (data) {
        noteData.push(data);
    };

    service.getNoteData = function () {
        var self = this;
        // TODO: figure out how to get user info when app bootstraps
        return $q(function (resolve, reject) {
            $http({
                method: 'GET',
                url: 'http://localhost/boostNote/note'
            }).then(function (response) {
                self.setNotes(response.data.notes);
                resolve(self.getNotes());
            }, function (err) {
                reject(err);
            });
        });
    };

    return service;
};

module.exports = noteService;