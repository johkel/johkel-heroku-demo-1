<?php

namespace App;

use PDO;

// krävs för att jobba med PDO som är en inbyggd klass eftersom vi har ett namespace

class Database
{
    private static ?Database $instance = null; // ?Database anger att den är av typen Database samt nullable
    private PDO $pdo;

    protected function __construct()
    {
        // om mysql på 000
//        $dsn = 'mysql:host=mysql#.000webhost.com;dbname=a336xxxx_test' , 'a336xxxx_test', '******', ;
        // om heroku finns så kan den hämta från getenv
        $db = parse_url(getenv("DATABASE_URL"));
        if (!empty($db["host"])) {
            $dsn = "pgsql:" . sprintf(
                    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
                    $db["host"],
                    $db["port"],
                    $db["user"],
                    $db["pass"],
                    ltrim($db["path"], "/")
                );
        } else {
            $dsn = "pgsql:host=localhost;port=5432;dbname=todo-demo;user=postgres;password=postgres";
            $dsn = 'mysql:host=localhost;dbname=id16355227_tododemo;user=id16355227_johkel;password=?7~gUzs}Gq%ULvld'; ;
        }
        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public static function findAllTasks(): array
    {
        $query = "select * from tasks";
        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findTask(int $id)
    {
        $query = "select * from tasks where id=:id";
        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function addTask(): bool
    {
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($title)) {
            return false;
        }
        $query = "insert into tasks(title) values(:title)";
        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->bindParam(":title", $title);
        return $stmt->execute();
    }

    public static function deleteTask(int $id): bool
    {
        $query = "delete from tasks where id=:id";
        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public static function saveTask(): bool
    {
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($title) || empty($id)) {
            return "empty";
        }
        $query = "update tasks set title=:title where id=:id";
        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $title);
        return $stmt->execute();
    }
}
