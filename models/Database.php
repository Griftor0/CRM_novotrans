<?php

namespace models;

use PDO;
use PDOException;

class Database{
    private static $instance = null;
    private $conn;

    private function __construct() {
        $db_host = DB_HOST;
        $db_user = DB_USER;
        $db_pass = DB_PASS;
        $db_name = DB_NAME;

        try{
            $dsn = "mysql:host=$db_host;dbname=$db_name";
            $this->conn = new PDO($dsn, $db_user, $db_pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo "Connect failed: " . $e->getMessage();
        }
    }

    public static function getInstance() {         // Вернуть единственный экземпляр класса
        if(!isset(self::$instance)) {              // Если экземпляр класса не существует, то создаем его
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
}