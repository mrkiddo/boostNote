'use strict';

var noteService = function ($q, $http) {
    var noteData = [];
    var noteModel = {
        'note_id': 0,
        'title': '',
        'content': ''
    };
    var selectedNote = {};

    var service = {};

    service.getBaseModel = function () {
        return angular.extend({}, noteModel);
    };

    service.getNotes = function () {
        return noteData;
    };

    service.setNotes = function (data) {
        noteData = data;
    };

    service.selectNote = function (noteId) {
        selectedNote = {};
        for(var i = 0; i < noteData.length; i++) {
            if(noteData[i].note_id === noteId) {
                selectedNote = noteData[i];
                return noteData[i];
            }
        }
    };

    service.getSelectNote = function () {
        return selectedNote;
    };

    service.deleteNote = function (index) {
        var note = noteData[index];
        noteData.splice(index, 1);
        return $q(function (resolve, reject) {
            $http({
                method: 'GET',
                url: 'http://localhost/boostNote/note/disable/id/' + note.note_id
            }).then(function (response) {
                var responseData = response.data;
                if(!responseData.success) {
                    reject(responseData.msg);
                }
                else {
                    resolve(true);
                }
            }, function (err) {
                reject(err);
            });
        });
    };

    service.addNote = function (data) {
        var newNote = data;
        return $q(function (resolve, reject) {
            $http({
                method: 'POST',
                url: 'http://localhost/boostNote/note/create',
                data: newNote
            }).then(function (response) {
                var responseData = response.data;
                if(!responseData.success) {
                    reject(responseData.msg);
                }
                else {
                    newNote['note_id'] = responseData['note_id'];
                    noteData.push(newNote);
                    resolve(newNote);
                }
            }, function (err) {
                reject(err);
            });
        });
    };

    service.updateNote = function (data) {
        return $q(function (resolve, reject) {
            $http({
                method: 'POST',
                url: 'http://localhost/boostNote/note/update/id/' + data.note_id,
                data: data
            }).then(function (response) {
                var responseData = response.data;
                if(!responseData.success) {
                    reject(responseData.msg);
                }
                else {
                    resolve(true);
                }
            }, function (err) {
                reject(err);
            });
        });
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