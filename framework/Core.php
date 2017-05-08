<?php

/**
 * framework core
 */
class Core
{
    /**
     * assign file auto load function
     */
    public function run ()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->route();
    }

    /**
     * @param string $class
     */
    public static function loadClass ($class)
    {
        $frameworks = FRAME_PATH.$class.'.class.php';
        $controllers = APP_PATH.'application/controllers/'.$class.'.class.php';
        $models = APP_PATH.'application/models/'.$class.'.class.php';
        $services = APP_PATH.'application/services/'.$class.'.class.php';
        $migrations = APP_PATH.'application/migrations/'.$class.'.class.php';
        if(file_exists($frameworks)) {
            include $frameworks;
        }
        else if(file_exists($controllers)) {
            include $controllers;
        }
        else if(file_exists($models)) {
            include $models;
        }
        else if(file_exists($services)) {
            include $services;
        }
        else if(file_exists($migrations)) {
            include $migrations;
        }
        else {
            if(APP_DEBUG === true) {
                var_dump($class);
                exit('specific file not exist');
                // if file not found, redirect to exception handler page
                $exceptionController = new ExceptionController('Exception', 'index');
                call_user_func(array($exceptionController, 'index'), array());
            }
        }
    }

    /**
     * apply router function
     */
    private function route()
    {
        $controllerName = DEFAULT_CONTROLLER;
        $action = 'index';
        $param = array();

        $url = isset($_GET['url']) ? $_GET['url'] : false;
        if($url) {
            $urlArray = explode('/', $url);
            $urlArray = array_filter($urlArray);
            $controllerName = ucfirst($urlArray[0]);
            array_shift($urlArray);
            $action = $urlArray ? $urlArray[0] : $action;
            array_shift($urlArray);
            $param = $urlArray ? $urlArray : $param;
        }

        $controller = $controllerName.'Controller';
        // create corresponding controller
        if(class_exists($controller)) {
            $dispatch = new $controller($controllerName, $action);

            if((int)method_exists($controller, $action)) {
                // call method Controller->action([$param])
                call_user_func_array(array($dispatch, $action), $param);
            }
            else {
                $dispatch = new ExceptionController('Exception', 'index');
                call_user_func(array($dispatch, 'index'), array());
            }
        }
    }

    /**
     * set reporting
     */
    private function setReporting ()
    {
        if(APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        }
        else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', RUNTIME_PATH.'logs/error.log');
        }
    }

    private function stripSlashesDeep ($value) {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripcslashes($value);
        return $value;
    }

    private function removeMagicQuotes ()
    {
        if(get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
        }
    }

    private function unregisterGlobals ()
    {
        if(ini_get('register_globals')) {
            $variableList = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach($variableList as $variable) {
                foreach($GLOBALS[$variable] as $key => $value) {
                    if($value === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }
}