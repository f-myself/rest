<?php

include "../../config.php";
include "../../libs/RestServer.php";
include "../../libs/PDOHandler.php";

class OrdersService
{
    private $sql;

    function __construct()
    {
        $this->sql = new PDOHandler;
    }

    public function getOrders($params)
    {
        return $params;
    }

    public function postOrders($params)
    {
        $id = trim(strip_tags($params['id']));
        $carId = trim(strip_tags($params['car']));
        $token = trim(strip_tags($params['token']));
        $payment = trim(strip_tags($params['payment']));
        $address = trim(strip_tags($params['address']));
        //var_dump($params);

        $loggedUser = $this->sql->newQuery()->select('token')->from('rest_users')->where('id=' . $id)->doQuery();
        $user = $loggedUser[0];

        if($token != $user['token'])
        {
            header("Status: 200 Ok");
            return ["status" => "err_token"];
        }

        if($id      and is_numeric($id)      and
           $carId   and is_numeric($carId)   and
           $token   and is_string($token)    and
           $payment and is_numeric($payment) and
           $address and is_string($address))
        {
            $order = $this->sql->newQuery()->insert("rest_orders", ["user_id", "payment_id", "address"], "'$id', '$payment', '$address'")->doQuery();
            $orderId = $this->sql->newQuery()
                                 ->select('id')
                                 ->from('rest_orders')
                                 ->order('id')
                                 ->limit(1, true)
                                 ->doQuery();
            $lastOrderId = $orderId[0]['id'];

            if ($order and $lastOrderId)
            {
                $cars_order = $this->sql->newQuery()->insert("rest_cars_orders", ["car_id", "order_id"], "$carId, $lastOrderId")->doQuery();
            }

            if($order and $cars_order)
            {
                header("Status: 200 Ok");
                return ["status" => "success"];
            }
        }
        header("HTTP/1.0 400 Bad Request");
        return ["status" => "failed"];
    }

    public function putOrders()
    {

    }

    public function deleteOrders()
    {

    }
}

$order = new OrdersService;
$server = new RestServer($order);