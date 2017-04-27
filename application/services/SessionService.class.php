<?php

/**
 * Session Service
 */
class SessionService
{
    /**
     * check if session is started
     * @return bool
     */
    public function isStart()
    {
        return isset($_SESSION) ? true : false;
    }

    /**
     * set session variables
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set($key, $value)
    {
        if(!$this->isStart()) {
            return false;
        }
        $_SESSION[$key] = $value;
        return $value;
    }

    /**
     * get a session variable
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        else {
            return false;
        }
    }

    /**
     * reset session
     */
    public function reset()
    {
        $_SESSION = array();
    }

    /**
     * end and destroy session
     */
    public function destroy()
    {
        $this->reset();
        session_destroy();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
}