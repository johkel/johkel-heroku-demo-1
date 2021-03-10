<?php
namespace App\Controllers;

/**
 * Class HomeController
 * @package App\Controllers
 * @author Johan Kellén
 */
class HomeController
{
    public function __construct()
    {

    }

    /**
     *  Default
     */
    public function index()
    {
        echo __METHOD__;
        // ToDo Write logic for index
    }

    public function error()
    {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        if($_GET["fel"]){ echo "fel"; }

    }

}