<?php

include "../../config.php";
include "../../libs/RestServer.php";
include "../../libs/PDOHandler.php";

class SignInService
{

    private $sql;

    function __construct()
    {
        $this->sql = new PDOHandler;
    }
    public function getSignin()
    {

    }

    public function postSignin()
    {

    }
    
    public function putSignin($params)
    {
        $id = trim(strip_tags($params['id']));
        $email = trim(strip_tags($params['email']));
        $password = trim(strip_tags($params['password']));
        $operation = trim(strip_tags($params['operation']));
        $requestToken = trim(strip_tags($params['token']));

        if ($operation == "login")
        {
            if($email and is_string($email) and $password and is_string($password))
            {
                $hashPassword = md5($password);
                $userLogin = $this->sql->newQuery()
                                       ->select(['id', 'nickname', 'password'])
                                       ->from('rest_users')
                                       ->where("email='$email'")
                                       ->doQuery();
                $user = $userLogin[0];
                
                if(!$user)
                {
                    return ["status" => "no_user"];
                }

                if($hashPassword != $user['password'])
                {
                    return ["status" => "err_password"];
                }

                $token = md5($user['name'] . time(microtime()));
                $tokenInput = $this->sql->newQuery()->update('rest_users', ['token'], ["'$token'"], 'id=' . $user['id'])->doQuery();

                if($tokenInput)
                {
                    $result = [
                        'id'       => $user['id'],
                        'nickname' => $user['nickname'],
                        'token'    => $token,
                        'status'   => 'success'
                    ];
                    return $result;
                }
            }
        }

        if ($operation == "logout")
        {
            if($id and is_numeric($id) and $requestToken and is_string($requestToken))
            {
                $userLogout = $this->sql->newQuery()
                                        ->select('token')
                                        ->from('rest_users')
                                        ->where("id=" . $id)
                                        ->doQuery();
                $user = $userLogout[0];

                if($requestToken != $user['token'])
                {
                    return ["status" => "err_token"];
                }

                $tokenInput = $this->sql->newQuery()->update('rest_users', ['token'], ['NULL'], 'id=' . $id)->doQuery();

                if($tokenInput)
                {
                    return ["status" => "success"];
                }
                return ["status" => "error"];
            }
            return ["status" => 400];
        }
    }

    public function deleteSignin()
    {

    }
}

$signin = new SignInService;
$server = new RestServer($signin);