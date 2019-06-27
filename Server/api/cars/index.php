<?php

//header('Status: 200 Ok');

include "../../config.php";
include "../../libs/RestServer.php";
include "../../libs/PDOHandler.php";

class CarsService
{

    private $sql;

    function __construct()
    {
        $this->sql = new PDOHandler;
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
            return $result;
        }
        
        if(isset($_GET['filter']))
        {
            $result = $this->getCarByParams($_GET['filter']);
            return $result;
        }
    }

    public function postCars()
    {
        
    }

    public function deleteCars()
    {
        
    }

    public function putCars()
    {
        
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
            if ($car[0])
            {
                return $car[0];
            } else {
                return ["status" => 204];
            }
        }
        return ["status" => 400];
    }

    private function getCarByParams($params)
    {
        $year = $params['year'];
        $model = $params['model'];
        $capacity = $params['capacity'];
        $color = $params['color'];
        $maxSpeed = $params['maxSpeed'];
        $price = $params['price'];

        if($year and is_numeric($year))
        {
            $carsByParams = $this->sql->newQuery()
                                  ->select(['c.id', 'b.brand', 'model'])
                                  ->from('rest_cars c')
                                  ->join('rest_brands b', 'c.brand_id=b.id')
                                  ->where("c.year<=" . $year);
        
        
            if ($model and is_string($model))
            {
                $carsByParams = $carsByParams->l_and("c.model='" . trim($model) . "'");
            }
            if ($capacity and is_numeric($capacity))
            {
                $carsByParams = $carsByParams->l_and("c.capacity<=" . $capacity);
            }
            if ($color and is_numeric($color))
            {
                $carsByParams = $carsByParams->l_and("c.color_id='" . trim($color) . "'");
            }
            if ($maxSpeed and is_numeric($maxSpeed))
            {
                $carsByParams = $carsByParams->l_and("c.max_speed<=" . $maxSpeed);
            }
            if ($price and is_numeric($price))
            {
                $carsByParams = $carsByParams->l_and("c.price<=" . $price);
            }
            $carsByParams = $carsByParams->doQuery();
            if ($carsByParams[0])
            {
                return $carsByParams;
            }
            return ["status" => "no_cars"];
        }
        return ["status" => 400];
    }
}

$cars = new CarsService;
$server = new RestServer($cars);