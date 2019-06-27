<?php

include "DataHandler.php";

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
        echo $this->chooseMethod($service);
    }

    function setMethod($method, $params=false)
    {
        if (method_exists($this->service, $method))
        {
            $result = call_user_func([$this->service, $method], $params);
        }
        return $result;
    }

    public function chooseMethod($service)
    {
        list($source, $user, $folder, $param, $api, $service, $params) = explode('/', $this->url, 7); //Server, api, cars, params
        // list($root, $source, $folder, $service, $params) = explode('/', $this->url, 6); //Server, api, cars, params
        $viewType = explode("/", $params);
        $viewType = array_pop($viewType);
        //print_r($viewType);

        switch($this->method)
        {
            case 'GET':
                $result = $this->setMethod('get'.ucfirst($service), explode('/', $params));
                break;
            case 'DELETE':
                $result = $this->setMethod('delete'.ucfirst($service), explode('/', $params));
                break;
            case 'POST':
                $params = $_POST;
                $result = $this->setMethod('post'.ucfirst($service), $params);
                break;
            case 'PUT':
                $params = array(); 
                $putdata = file_get_contents('php://input'); 
                $exploded = explode('&', $putdata);  
                
                foreach($exploded as $pair) 
                { 
                    $item = explode('=', $pair); 
                    if(count($item) == 2) 
                    { 
                        $params[urldecode($item[0])] = urldecode($item[1]); 
                    } 
                }
                $result = $this->setMethod('put'.ucfirst($service), $params);
                break;
            default:
                return false;
        }

        switch($viewType)
        {
            case ".json":
                return $this->showResults($result, VIEW_JSON);
                break;
            case ".txt":
                return $this->showResults($result, VIEW_TEXT);
                break;
            case ".xml":
                return $this->showResults($result, VIEW_XML);
                break;
            case ".html":
                return $this->showResults($result, VIEW_HTML);
                break;
            default:
                return $this->showResults($result, VIEW_JSON);
        }
    }

    private function showResults($data, $viewType=VIEW_JSON)
    {
        $dh = new DataHandler($data, $viewType);
        return $dh->getResult();
    }
}