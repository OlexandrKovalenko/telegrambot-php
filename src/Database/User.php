<?php

namespace App\Database;

use App\Botlogger\BotLogger;
use Exception;
use PDO;

class User
{
    private PDO $query;

    public function __construct()
    {
        $db = new DBConnect();
        $this->query = $db->connect();
    }

    function find($id)
    {
        $stmt = $this->query->prepare('SELECT * FROM user where id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function findByTelegramId($telegram_id)
    {
        $stmt = $this->query->prepare('SELECT * FROM user where telegram_id = ?');
        $stmt->execute([$telegram_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function create($data): string
    {
        $stmt = $this->query->prepare(
            "INSERT INTO user (telegram_id, username, first_name, last_name, language_code) values (:id, :username, :first_name, :last_name, :language_code)"
        );
        $first_name = $data['first_name'] ?? null;
        $last_name = $data['last_name'] ?? null;
        $username = $data['username'] ?? null;
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':language_code', $data['language_code']);
        $stmt->execute();
        return $this->query->lastInsertId();
    }

    function update($id, $data): object
    {
        $row = key($data);
        $sql = "UPDATE user SET $row=:data WHERE telegram_id=:id";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([
            ':data' => $data[$row],
            ':id' => $id
        ]);
        return self::findByTelegramId($id);
    }
}