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

    /**
     * @param array $data
     */
    public function setUserInfo($data)
    {
        $this->set('user_id', $data['id']);
        $this->set('user_email', $data['email']);
        $this->set('last_name', $data['last_name']);
        $this->set('first_name', $data['first_name']);
    }

    /**
     * @return array
     */
    public function getUserInfo()
    {
        return array(
            'user_id' =>$this->get('user_id'),
            'user_email' => $this->get('user_email'),
            'last_name' => $this->get('last_name'),
            'first_name' => $this->get('first_name')
        );
    }
}