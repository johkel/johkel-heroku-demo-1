<?php
namespace App\Controllers;

use App\Database;

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
        $all = Database::findAllTasks();
        echo $all;

    }

}