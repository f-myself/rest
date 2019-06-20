<?php

include "../../services/CarsService.php";
include "../../libs/RestServer.php";


$cars = new CarsService;
$server = new RestServer($cars);