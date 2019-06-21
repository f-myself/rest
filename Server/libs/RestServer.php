<?php

class RestServer 
{
    private $service;
    private $url;
    private $method;

    function __construct($service)
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        if(is_object($service))
        {
            $this->service = $service;
        }
        $this->chooseMethod($service);
    }


    function setMethod($method, $params=false)
    {
        print_r( $params);
        if (method_exists($this->service, $method))
        {
            $result = call_user_func([$this->service, $method], $params);
        }

        return $result;
    }

    public function chooseMethod($service)
    {
        // list($source, $folder, $service, $param1, $table, $path) = explode('/', $url, 6); //Server, api, cars, params
        list($root, $source, $folder, $service, $params) = explode('/', $this->url, 6); //Server, api, cars, params
        // echo $this->url;
        //echo $source . "\n";
        // echo $folder . "\n";
        // echo $service . "\n";
        // echo $params . "\n";
        // echo $s . "\n";
        // echo $a . "\n";
        // echo $d . "\n";
        // echo $db . "\n";
        // echo $table . "\n";
        // echo $path . "\n";

        switch($this->method)
        {
            case 'GET':
                $result = $this->setMethod('get'.ucfirst($service), explode('/', $params));
                break;
            case 'DELETE':
                $result = $this->setMethod('delete'.ucfirst($service), explode('/', $params));
                break;
            case 'POST':
                $result = $this->setMethod('post'.ucfirst($service), explode('/', $params));
                break;
            case 'PUT':
                $result = $this->setMethod('put'.ucfirst($service), explode('/', $params));
                break;
            default:
                return false;
        }

        $this->showResults($result);

        
        // echo "<pre>";
        // var_dump($this->service->getCars());
        // echo "</pre>";
    }

    private function showResults($result)
    {
        echo "<pre>";
        var_dump($result);
        echo "</pre>";
    }
}