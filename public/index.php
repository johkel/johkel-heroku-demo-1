<?php

//konstanter för sökvägar
define('ROOT', dirname(__DIR__));
define('APP', ROOT . DIRECTORY_SEPARATOR . 'app');
define('PUB', ROOT . DIRECTORY_SEPARATOR . 'public');

// läs in alla tillägg i vendor
require_once ROOT . "/vendor/autoload.php";

// routing
require_once APP . "/routes.php";

