<?php

/**
 * Note Controller Class
 */
class NoteController extends Controller
{
    /**
     * handle note getting requests
     * @param string $paramName
     * @param string $value
     * @return void
     */
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
        $this->setHeaderFormat('json');
        echo json_encode($data);
    }

    /**
     * handle note creating requests
     * @return void
     */
    public function create()
    {
        // check session
        //$userId = $this->checkUserAuth();
        $userId = 1000;
        $data = array(
            'user_id' => $userId,
            'title' => $_POST['title'],
            'content' => $_POST['content']
        );
        $noteService = new NoteService();
        $result = $noteService->createNote($data);
        $this->setHeaderFormat('json');
        echo json_encode($result);
    }

    /**
     * handle note updating requests
     * @param string $paramName
     * @param string $value
     * @return void
     */
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
        $this->setHeaderFormat('json');
        echo json_encode($result);
    }

    /**
     * handle note disable requests
     * @param string $paramName
     * @param string $value
     * @return void
     */
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
        $this->setHeaderFormat('json');
        echo json_encode($result);
    }
}