<?php

include "../../config.php";
include "../../libs/RestServer.php";
include "../../libs/PDOHandler.php";

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

    private function checkRepeat($nickname, $email)
    {
        $nickMails = $this->sql->newQuery()
                              ->select(['nickname', 'email'])
                              ->from('rest_users')
                              ->where("nickname='$nickname'")
                              ->l_or("email='$email'")
                              ->doQuery();
        if ($nickMails[0])
        {
            return false;
        }
        return true;
    }

    public function postSignup($params)
    {
        $name     = trim(strip_tags($params['name']));
        $nickname = trim(strip_tags($params['nickname']));
        $email    = trim(strip_tags($params['email']));
        $password = trim(strip_tags($params['password']));
        $confirm  = trim(strip_tags($params['confirm']));

        if ($password != $confirm)
        {
            return ["status" => "password"];
        }

        if(!$this->checkRepeat($nickname, $email))
        {
            return ["status" => "exists"];
        }

        $signup = $this->sql->newQuery();

        if ($name and is_string($name) and 
            $nickname and is_string($nickname) and
            $email and filter_var($email, FILTER_VALIDATE_EMAIL) and
            $password)
        {
            $hashPassword = md5($password);
            $signup = $signup->insert("rest_users", ['name', 'nickname', 'email', 'password'], "'$name', '$nickname', '$email', '$hashPassword'")->doQuery();
            // $signup = true;
            if($signup)
            {
                return ["status" => "success"];
            }
        }
        return ["status" => 400];
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

$signup = new SignUpService;
$server = new RestServer($signup);