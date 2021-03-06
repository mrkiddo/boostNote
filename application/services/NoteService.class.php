<?php

/**
 * NoteService Class
 */
class NoteService
{
    /**
     * validate data input
     * @param array $data
     * @return bool
     */
    public function validateData($data) {
        if(!isset($data['user_id']) || empty($data['user_id'])) {
            return false;
        }
        else if(!isset($data['title']) || empty($data['title'])) {
            return false;
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
     * @param string|int $userId
     * @param string|int $noteId
     * @return array
     */
    public function getNotes($userId, $noteId = '')
    {
        $noteModel = new NotesModel();
        $data = $noteModel->get($userId, $noteId);
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
     * @param int|string $noteId
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
                'code' => 2
            );
        }
        $noteContentModel = new Note_ContentModel();

        $title = $this->escapeContent($data['title']);
        $content = $this->escapeContent($data['content']);

        $result = $noteContentModel
                                    ->updateContent($noteId, $title, $content);
        if($result) {
            return array(
                'success' => true,
                'msg' => 'note update successfully',
                'code' => 0,
                'note_id' => $noteId
            );
        }
        else if($result === 0) {
            return array(
                'success' => true,
                'msg' => 'note is not modified',
                'code' => 1,
                'note_id' => $noteId
            );
        }
        else {
            return array(
                'success' => false,
                'msg'=> 'note update fails',
                'code' => 3,
                'note_id' => $noteId
            );
        }
    }

    /**
     * disable a note
     * @param int|string $noteId
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
        $result = $noteModel->disable($noteId);
        if($result) {
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