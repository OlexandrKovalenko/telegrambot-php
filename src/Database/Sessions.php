<?php

namespace App\Database\Sessions;


use App\Database\DBConnect;
use PDO;

class Sessions
{
    private PDO $query;

    public function __construct()
    {
        $db = new DBConnect();
        $this->query = $db->connect();
    }
}