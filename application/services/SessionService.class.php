<?php

/**
 * Created by PhpStorm.
 * User: mrkiddo
 * Date: 2017/4/22
 * Time: 12:49
 */
class SessionService
{
    public function isStart()
    {
        return isset($_SESSION) ? true : false;
    }

    public function set($key, $value)
    {
        if(!$this->isStart()) {
            return false;
        }
        $_SESSION[$key] = $value;
        return $value;
    }

    public function get($key)
    {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        else {
            return false;
        }
    }

    public function reset()
    {
        $_SESSION = array();
    }

    public function destroy()
    {
        session_destroy();
    }
}