<?php

include "../../config.php";
include "../../libs/RestServer.php";
include "../../libs/PDOHandler.php";

class SignInService
{
    function __construct()
    {

    }
    public function getSignin()
    {

    }

    public function postSignin()
    {

    }
    
    public function putSignin($params)
    {
        $email = trim(strip_tags($params['email']));
        $password = trim(strip_tags($params['password']));
        $operation = trim(strip_tags($params['operation']));

        if ($operation == "login")
        {
            if($email and is_string($email) and $password and is_string($password))
            {

            }
        }

        if ($operation == "logout")
        {
            
        }
        


        // var_dump($params);
    }

    public function deleteSignin()
    {

    }
}

$signin = new SignInService;
$server = new RestServer($signin);