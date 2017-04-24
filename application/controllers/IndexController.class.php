<?php

/**
 * Index controller
 */
class IndexController extends Controller
{
    public function index()
    {
        $sessionService = new SessionService();
        $userId = $sessionService->get('user_id');
        if(!$userId) {
            $this->assign('redirectUrl', 'http://localhost/boostNote/users');
            $this->render('redirect');
        }
        else {
            $this->assign('title', 'this is index page');
            $this->assign('content', 'boosted by myMvc');
            $this->render();
        }
    }
}