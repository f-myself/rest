<?php

define('DB_DRV_MYSQL', 'mysql');
define('DB_DRV_PGSQL', 'pgsql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'rest_cars_shop');

define('VIEW_TYPE_DEFAULT', '.json');
define('ERR_CAR_BY_PARAMS', "No car by this params. Please, try again");

/** View types **/
define('VIEW_JSON', 'json');
define('VIEW_HTML', 'html');
define('VIEW_XML', 'xml');
define('VIEW_TEXT', 'txt');


/* Error messages */
define('ERR_CONNECT_DB', "Cannot connect database. Check username or password");