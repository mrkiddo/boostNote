<?php

/**
 * NoteService Class
 */
class NoteService
{
    /**
     * validate data to be processed
     * @param array $data
     * @return bool
     */
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

    /**
     * @param string $content
     * @return string
     */
    public function escapeContent($content)
    {
        $content = addslashes($content);
        $content = htmlspecialchars($content);
        return $content;
    }

    /**
     * @param string $content
     * @return string
     */
    public function unescapeContent($content)
    {
        $content = stripcslashes($content);
        $content = htmlspecialchars_decode($content);
        return $content;
    }

    /**
     * retrieve and process note data
     * @param string|number $userId
     * @param string|number $noteId
     * @return array
     */
    public function getNotes($userId, $noteId = '')
    {
        $noteModel = new NotesModel();
        $data = $noteModel->getNotes($userId, $noteId);
        $results = array();
        $results['user_id'] = $userId;
        $results['count'] = count($data);
        $results['notes'] = array();
        if(count($data) > 0) {
            foreach($data as $item) {
                $results['notes'][] = array(
                    'note_id' => intval($item['note_id']),
                    'owner_id' => intval($item['owner_id']),
                    'creation_time' => $item['creation_time'],
                    'last_update_time' => $item['last_update_time'],
                    'shares' => intval($item['shares']),
                    'disable' => intval($item['disable']),
                    'content_id' => intval($item['content_id']),
                    'title' => $this->unescapeContent($item['title']),
                    'content' => $this->unescapeContent($item['content'])
                );
            }
        }
        return $results;
    }

    /**
     * create a new note
     * @param array $data
     * @return array
     */
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
            $title = $this->escapeContent($data['title']);
            $content = $this->escapeContent($data['content']);
            $finalResult = $noteContentModel
                            ->create($newNoteId, $title, $content);
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

    /**
     * update a note
     * @param number $noteId
     * @param array $data
     * @return array
     */
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

        $title = $this->escapeContent($data['title']);
        $content = $this->escapeContent($data['content']);

        $resultFromNote = $noteModel->updateNote($noteId);
        $resultFromNoteContent = $noteContentModel
                                    ->updateContent($noteId, $title, $content);
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

    /**
     * disable a note
     * @param number $noteId
     * @return array
     */
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