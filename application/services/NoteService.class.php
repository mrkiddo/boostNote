<?php

/**
 * Created by PhpStorm.
 * User: mrkiddo
 * Date: 2017/4/22
 * Time: 16:10
 */
class NoteService
{
    public function validateData($data) {
        foreach($data as $key => $value) {
            if($key === 'user_id' || $key == 'title') {
                if(empty($value)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function createNote($data) {
        $valid = $this->validateData($data);
        if(!$valid) {
            return array(
                'success' => false,
                'msg' => 'required data is not provided',
                'code' => 1
            );
        }

        $noteModel = new NotesModel();
        $noteContentModel = new Note_ContentModel();

        $result = $noteModel->create($data);
        if(!empty($result['id'])) {
            $newNoteId = $result['id'];
            $finalResult = $noteContentModel
                            ->create($newNoteId, $data['title'], $data['content']);
            if(empty($finalResult['id'])) {
                return array(
                    'success' => false,
                    'msg' => 'create new note content fails',
                    'code' => 3
                );
            }
        }
        else {
            return array(
                'success' => false,
                'msg' => 'create new note fails',
                'code' => 2
            );
        }
        return array(
            'success' => true,
            'msg' => 'create new note successfully',
            'code' => 0,
            'note_id' => $newNoteId
        );
    }

    public function updateNote($noteId, $data)
    {
        $valid = $this->validateData($data);
        if(!isset($noteId) || !$valid) {
            return array(
                'success' => false,
                'msg' => 'required data is not provided',
                'code' => 1
            );
        }
        $noteModel = new NotesModel();
        $noteContentModel = new Note_ContentModel();
        $resultFromNote = $noteModel->updateNote($noteId);
        $resultFromNoteContent = $noteContentModel->updateContent($noteId, $data['title'], $data['content']);
        if($resultFromNote && $resultFromNoteContent) {
            return array(
                'success' => true,
                'msg' => 'note update successfully',
                'code' => 0,
                'note_id' => $noteId
            );
        }
        else {
            return array(
                'success' => false,
                'msg' => 'note update fails',
                'code' => 2,
                'note_id' => $noteId
            );
        }
    }

    public function disableNote($noteId)
    {
        if(!isset($noteId)) {
            return array(
                'success' => false,
                'msg' => 'required data is not provided',
                'code' => 1
            );
        }
        $noteModel = new NotesModel();
        $noteContentModel = new Note_ContentModel();
        $resultFromNote = $noteModel->disableNote($noteId);
        $resultFromNoteContent = $noteContentModel->disableContent($noteId);
        if($resultFromNote && $resultFromNoteContent) {
            return array(
                'success' => true,
                'msg' => 'note disable successfully',
                'code' => 0,
                'note_id' => $noteId
            );
        }
        else {
            return array(
                'success' => false,
                'msg' => 'note disable fails',
                'code' => 2,
                'note_id' => $noteId
            );
        }
    }
}