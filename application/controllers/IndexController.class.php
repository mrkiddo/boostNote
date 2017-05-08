<?php

/**
 * Index controller
 */
class IndexController extends Controller
{
    /**
     * action /index, main page
     */
    public function index()
    {
        $sessionService = new SessionService();
        $userId = $sessionService->get('user_id');
        if(!$userId) {
            $this->assign('redirectUrl', SITE_URL.'/user/login');
            $this->render('redirect');
        }
        else {
            $this->assign('title', 'Boost Note');
            $this->assign('content', 'boosted by myMvc');
            $this->render();
        }
    }
}