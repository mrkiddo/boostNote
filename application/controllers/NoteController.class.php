<?php

/**
 * Created by PhpStorm.
 * User: mrkiddo
 * Date: 2017/4/22
 * Time: 14:29
 */
class NoteController extends Controller
{
    protected function checkUserAuth()
    {
        $sessionService = new SessionService();
        $userId = $sessionService->get('user_id');
        if(!$userId) {
            // auth fail, send 403
        }
        return $userId;
    }

    public function index($paramName = '', $value = '')
    {
        // check session
        //$userId = $this->checkUserAuth();
        $userId = 1000;
        $noteModel = new NotesModel();
        if($paramName === 'id' && $value) {
            $noteId = $value;
        }
        if(isset($noteId)) {
            $data = $noteModel->findOne($userId, $noteId);
        }
        else {
            $data = $noteModel->findAll($userId);
        }
        echo json_encode($data);
    }

    public function create()
    {
        // check session
        //$userId = $this->checkUserAuth();
        $userId = 1000;
        $data = array(
            'title' => $_POST['title'],
            'content' => $_POST['content']
        );
        $noteService = new NoteService();
        $result = $noteService->createNote($data);
        echo json_encode($result);
    }

    public function update($paramName = '', $value = '') {
        // check session
        //$userId = $this->checkUserAuth();
        $userId = 1000;
        $noteId = null;
        if($paramName === 'id' && $value) {
            $noteId = $value;
        }
        $data = array(
            'title' => $_POST['title'],
            'content' => $_POST['content']
        );
        $noteService = new NoteService();
        $result = $noteService->updateNote($noteId, $data);
        echo json_encode($result);
    }

    public function disable($paramName = '', $value = '')
    {
        // check session
        //$userId = $this->checkUserAuth();
        $userId = 1000;
        $noteId = null;
        if($paramName === 'id' && $value) {
            $noteId = $value;
        }
        $noteService = new NoteService();
        $result = $noteService->disableNote($noteId);
        echo json_encode($result);
    }
}