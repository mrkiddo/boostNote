<?php

/**
 * User Model
 */
class UsersModel extends Model
{
    /**
     * check input data
     * @param array $data
     * @return array|bool
     */
    public function validateData($data)
    {
        if(!isset($data)) {
            return false;
        }
        $toValidate = array(
            'email' => isset($data['email']) ? $data['email'] : '',
            'pwd' => isset($data['pwd']) ? $data['pwd'] : ''
        );
        $result = array(
            'valid' => true,
            'msg' => '',
            'code' => 0
        );
        foreach($toValidate as $key => $value) {
            if($key === 'email') {
                if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
                    $result['valid'] = false;
                    $result['msg'] .= 'invalid email format';
                    $result['code'] = 1;
                }
            }
            else if($key === 'pwd') {
                if(strlen($value) > 16 || strlen($value) < 6) {
                    $result['valid'] = false;
                    $result['msg'] .= 'invalid password input';
                    $result['code'] = 2;
                }
            }
        }
        return $result;
    }

    /**
     * check if email is occupied in system
     * @param string $email
     * @param bool $checkDisable
     * @return bool
     */
    public function checkEmailExists($email, $checkDisable = false)
    {
        $condition = array(
            "email = '".$email."'",
        );
        if($checkDisable) {
            array_push($condition, "disable = 0");
        }
        $result = $this->where($condition)->limit(1)->select();
        return count($result) > 0 ? true : false;
    }

    public function createUser($email, $pwd, $info = array())
    {
        if($this->checkEmailExists($email, false)) {
            return array(
                'success' => false,
                'msg' => 'email already be used',
                'code' => 1
            );
        }

        $data = array(
            'email' => $email,
            'password' => md5($pwd),
            'disable' => 0
        );
        if(isset($info)) {
            $data['last_name'] = $info['last_name'];
            $data['first_name'] = $info['first_name'];
        }
        $r = $this->add($data);
        if($r > 0) {
            $result = array(
                'success' => true,
                'msg' => 'user successfully created',
                'code' => 0
            );
        }
        else {
            $result = array(
                'success' => false,
                'msg' => 'user creation fails',
                'code' => 2
            );
        }
        return $result;
    }

    public function validateUser($email, $pwd)
    {
        $record = $this->checkEmailExists($email, true);
        if(count($record) === 0) {
            $result = array(
                'valid' => false,
                'msg' => 'user not exist',
                'code' => 1
            );
            return $result;
        }
        if($record[0]['password'] !== md5($pwd)) {
            $result = array(
                'valid' => false,
                'msg' => 'password incorrect',
                'code' => 2
            );
            return $result;
        }
        else {
            $result = array(
                'valid' => true,
                'msg' => 'email and password match',
                'code' => 0,
                'data' => $record[0]
            );
        }
        return $result;
    }

    public function updateUser($id, $info)
    {
        $result = $this->update($id, $info);
        return ($result > 0) ? true : false;
    }
}