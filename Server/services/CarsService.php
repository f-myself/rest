<?php

include "../config.php";
include "../libs/PDOHandler.php";

class CarsService
{

    private $sql;

    function __construct()
    {
        $this->sql = new PDOHandler;
    }

    public function getCars()
    {
        $allcars = $this->sql->newQuery()->select(['c.id', 'b.brand', 'model'])->from('rest_cars c')->join('rest_brands b', 'c.brand_id=b.id')->doQuery();
        return $allcars;
    }
}