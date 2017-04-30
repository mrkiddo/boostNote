<?php

/**
 * Controller base class
 */
class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;

    /**
     * Controller constructor.
     * @param string $controller
     * @param string $action
     */
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
    }

    /**
     * assign values for view template
     * @param string $name
     * @param string $value
     */
    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

    /**
     * specify view template and render
     * @param string $template
     */
    public function render ($template = '')
    {
        $this->_view->render($template);
    }

    /**
     * check if user is logged and return user_id
     * @return number $userId
     */
    protected function checkUserAuth()
    {
        if(APP_DEBUG === true && MOCK_USER_ID === true) {
            $userId = 1000;
            return $userId;
        }
        $sessionService = new SessionService();
        $userId = $sessionService->get('user_id');
        if(!$userId) {
            // auth fail, send 403
            $this->setHttpCode(403);
            exit();
        }
        return $userId;
    }

    /**
     * set header for response data
     * @param string $format
     */
    protected function setHeaderFormat($format = 'json')
    {
        if($format === 'json') {
            header('Content-type: text/json');
        }
    }

    /**
     * set http response code
     * @param int $code
     */
    protected function setHttpCode($code = 200) {
        http_response_code($code);
    }
}