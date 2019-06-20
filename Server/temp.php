<?php

echo $_SERVER["PHP_SELF"];

include "config.php";
include "services/CarsService.php";

$obj = new CarsService;

echo "<pre>";
var_dump($obj->getCars());
echo "</pre>";