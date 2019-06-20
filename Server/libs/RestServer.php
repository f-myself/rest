<?php

class RestServer 
{
    private $service;

    function __construct($service)
    {
        if(is_object($service))
        {
            $this->service = $service;
        }
        $this->chooseMethod($service);
    }

    public function chooseMethod($service)
    {
        $url = $_SERVER['REQUEST_URI'];

        list($s, $a, $d, $db, $table, $path) = explode('/', $url, 6); //rest, Server, api, cars, params
       
        

    }
}