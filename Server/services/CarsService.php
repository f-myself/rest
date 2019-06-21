<?php

include "../../config.php";
include "../../libs/PDOHandler.php";

class CarsService
{

    private $sql;

    function __construct()
    {
        $this->sql = new PDOHandler;
    }

    private function getAllCars()
    {
        $allcars = $this->sql->newQuery()
                             ->select(['c.id', 'b.brand', 'model'])
                             ->from('rest_cars c')
                             ->join('rest_brands b', 'c.brand_id=b.id')
                             ->doQuery();
        return $allcars;
    }

    private function getCarById($id)
    {
        if(is_numeric($id))
        {
            $car = $this->sql->newQuery()->select(['c.id, b.brand, c.model', 'c.year', 'c.capacity', 'cl.color', 'c.max_speed', 'c.price'])
                             ->from('rest_cars c')
                             ->join('rest_brands b', 'c.brand_id=b.id')
                             ->join('rest_colors cl', 'c.color_id=cl.id')
                             ->where('c.id=' . $id)
                             ->doQuery();
            return $car[0];
        }
    }

    private function getCarByParams($params)
    {
        echo "<pre>";
        var_dump($params);
        echo "</pre>";
        return "This is the cars by params";
    }
    
    public function getCars($params=false)
    {
        if(is_numeric($params[0]))
        {
            $result = $this->getCarById($params[0]);
            return $result;
        }
        
        if(!$params[0])
        {
            $result = $this->getAllCars();
            print_r($result);
            return $result;
        }
        
        if(isset($_GET['filter']))
        {
            $this->getCarByParams($_GET['filter']);
        }
    }

    public function postCars()
    {
        return false;
    }

    public function deleteCars()
    {
        return false;
    }

    public function putCars()
    {
        return false;
    }
}