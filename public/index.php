<?php

// SÄTT PÅ ERRORRAPPORTERING MED PHP
// detta MÅSTE tas bort innan man går live på riktigt
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

//konstanter för sökvägar
define('ROOT', dirname(__DIR__));
define('APP', ROOT . DIRECTORY_SEPARATOR . 'app');
define('PUB', ROOT . DIRECTORY_SEPARATOR . 'public');

// läs in debugfilen ifall det behövs
require_once APP . "/debug.php";

// läs in alla tillägg i vendor
require_once ROOT . "/vendor/autoload.php";

// routing
require_once APP . "/routes.php";

