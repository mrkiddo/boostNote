<?php

/**
 *
 */
class UserController extends Controller
{
    /**
     * action /index
     */
    public function index()
    {
        $sessionService = new SessionService();
        $userId = $sessionService->get('user_id');
        if($userId) {
            $this->assign('redirectUrl', 'http://localhost/boostNote/index');
            $this->render('redirect');
        }
        else {
            $this->assign('title', 'Sign In');
            $this->assign('loginPath', 'user/login');
            $this->render('login'); // render login page
        }
    }

    /**
     * action /register
     */
    public function register()
    {
        $this->assign('title', 'Sign Up');
        $this->render('register');
    }

    /**
     * action /create
     */
    public function create()
    {
        // from post data
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $info = array(
            'last_name' => $_POST['last_name'],
            'first_name' => $_POST['first_name']
        );

        $usersModel = new UsersModel();
        $result = $usersModel->createUser($email, $pwd, $info);
        if(!$result['success']) {
            $this->assign('title', 'Sign Up');
            $this->assign('error', $result['msg']);
            $this->render('register'); // render register page
        }
        else {
            // if success, redirect to login
            $this->assign('title', 'Sign In');
            $this->assign('loginPath', 'user/login');
            $this->render('login'); // render login page
        }
    }

    /**
     * action /update
     */
    public function update()
    {
        // from post data
    }

    /**
     * action /login
     */
    public function login()
    {
        // from post data
        $email = '';
        $pwd = '';
        if(isset($_POST['email']) && isset($_POST['pwd'])) {
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
        }
        $userModel = new UsersModel();
        $validate = $userModel->validateData(array(
            'email' => $email,
            'pwd' => $pwd
        ));
        if(!$validate['valid']) {
            $this->assign('title', 'Sign In');
            $this->assign('error', $validate['msg']);
            $this->render('login');
        }
        $result = $userModel->validateUser($email, $pwd);
        if(!$result['valid']) {
            $this->assign('title', 'Sign In');
            $this->assign('error', $result['msg']);
            $this->render('login'); // render login page
        }
        else {
            $sessionService = new SessionService();
            $sessionService->set('user_id', $result['data']['id']);
            $sessionService->set('user_email', $result['data']['email']);
            $sessionService->set('last_name', $result['data']['last_name']);
            $sessionService->set('first_name', $result['data']['first_name']);
            $this->assign('redirectUrl', 'http://localhost/boostNote/index');
            $this->render('redirect');
        }
    }

    /**
     * action /logout
     */
    public function logout()
    {
        $sessionService = new SessionService();
        $sessionService->destroy();
        $this->assign('title', 'Sign in');
        $this->assign('loginPath', 'user/login');
        $this->render('login');
    }
}