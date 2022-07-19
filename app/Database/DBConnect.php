<?php

namespace App\Database;


use App\env;
use PDO;
use PDOException;

class DBConnect extends env
{
    private string $servername;
    private string $username;
    private string $password;
    private string $dbname;

    public function __construct()
    {
        $this->servername = self::HOST;
        $this->username = self::USERNAME;
        $this->password = self::PASSWORD;
        $this->dbname = self::DBNAME;
    }

    function connect(): PDO
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}