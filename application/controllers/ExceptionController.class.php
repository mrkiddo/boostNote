<?php

/**
 *
 */
class ExceptionController extends Controller
{
    public function index()
    {
        $this->assign('title', 404);
        $this->assign('content', 'Resource Not Found');
        $this->render();
    }
}