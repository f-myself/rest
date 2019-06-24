<?php

include "../../../config.php";
include "../../../libs/RestServer.php";
include "../../../libs/PDOHandler.php";

class SignUpService
{

    private $sql;

    function __construct()
    {
        $this->sql = new PDOHandler;
    }

    public function getSignup()
    {
        
    }

    public function postSignup($params)
    {
        $name     = trim(strip_tags($params['name']));
        $nickname = trim(strip_tags($params['nickname']));
        $email    = trim(strip_tags($params['email']));
        $password = trim(strip_tags($params['password']));
        $confirm  = trim(strip_tags($params['confirm']))

        if ($password != $confirm)
        {
            header("HTTP/1.0 400 Bad Request");
            return "password";
        }

        $signup = $this->sql->newQuery();

        if ($name and is_string($name) and 
            $nickname and is_string($nickname) and
            $email and filter_var($email, FILTER_VALIDATE_EMAIL) and
            $password)
        {
            $hashPassword = md5($password);
            $signup = $signup->insert("rest_users", ['name', 'nickname', 'email', 'password'], "'$name', '$nickname', '$email', '$password'")->doQuery();

            if($signup)
            {
                header('Status: 200 Ok');
                return 'success';
            }
        }
        header("HTTP/1.0 400 Bad Request");
        return 'failed';
    }

    public function putSignup()
    {
        return true;
    }

    public function deleteSignup()
    {
        return true;
    }
}