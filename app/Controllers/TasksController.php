<?php

namespace App\Controllers;

use App\Database;
use App\View;

/**
 * Class TasksController
 * @package App\Controllers
 * @author Johan Kellén
 */
class TasksController
{
    public function __construct()
    {

    }

    /**
     *  Show general listing from db
     */
    public function index()
    {

        $db = parse_url(getenv("DATABASE_URL"));

        $pdo = new \PDO("pgsql:" . sprintf(
                "host=%s;port=%s;user=%s;password=%s;dbname=%s",
                $db["host"],
                $db["port"],
                $db["user"],
                $db["pass"],
                ltrim($db["path"], "/")
            ));
        var_dump($db);
        var_dump($pdo);
        exit();
        $data = [
            "tasks" => Database::findAllTasks()
        ];
        View::render("index.twig", $data);
    }

    /**
     *  Show edit view
     * @param $vars
     */
    public function edit($vars)
    {
        $id = $vars;
        $data = [
            "task" => Database::findTask($id)
        ];

        View::render("edit.twig", $data);
    }

    /**
     *  Delete in db
     * @param $vars
     */
    public function delete($vars)
    {
        Database::deleteTask($vars);
        header("Location:/tasks");
    }

    /**
     *  Update item in db
     */
    public function update()
    {
        Database::saveTask();
        header("Location:/tasks");
    }

    /**
     *  Insert into to db
     */
    public function store()
    {
        Database::addTask();
        header("Location:/tasks");
    }

}