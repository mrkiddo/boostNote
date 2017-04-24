<?php

/**
 * View base class
 */
class View
{
    protected $variables = array();
    protected $_controller;
    protected $_action;

    public function __construct($controller, $action)
    {
        $this->_controller = lcfirst($controller);
        $this->_action = $action;
    }

    public function assign ($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function render($template = '') {
        extract($this->variables);
        $defaultHeader = APP_PATH.'application/views/header.php';
        $defaultFooter = APP_PATH.'application/views/footer.php';
        $defaultLayout = APP_PATH.'application/views/layout.php';

        if(empty($template)) {
            $controllerHeader = APP_PATH.'application/views/'.$this->_controller.'/header.php';
            $controllerFooter = APP_PATH.'application/views/'.$this->_controller.'/footer.php';
            $controllerLayout = APP_PATH.'application/views/'.$this->_controller.'/layout.php';
        }
        else {
            $controllerHeader = APP_PATH.'application/views/'.$template.'/header.php';
            $controllerFooter = APP_PATH.'application/views/'.$template.'/footer.php';
            $controllerLayout = APP_PATH.'application/views/'.$template.'/layout.php';
        }

        if(file_exists($controllerHeader)) {
            include($controllerHeader);
        }
        else {
            include($defaultHeader);
        }
        if(file_exists($controllerFooter)) {
            include($controllerFooter);
        }
        else {
            include($defaultFooter);
        }
        if(file_exists($controllerLayout)) {
            include($controllerLayout);
        }
        else {
            include($defaultLayout);
        }
    }
}