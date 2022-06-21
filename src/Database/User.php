<?php

namespace App\Database\Users;


use App\Database\DBConnect;
use PDO;

class User
{
    private PDO $query;
    private DBConnect $db;

    public function __construct()
    {
        $this->db = new DBConnect();
        $this->query = $this->db->connect();
    }

    function find($id): object {
        $stmt = $this->query->prepare('SELECT * FROM user where id = ?');
        $stmt->execute([$id]);
        return $user = $stmt->fetch(PDO::FETCH_OBJ);
    }

    function findTelegramId($telegram_id): object {
        $stmt = $this->query->prepare('SELECT * FROM user where $telegram_id = ?');
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
        $sql = "UPDATE user SET $row=:data WHERE id=:id";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([
            ':data' => $data[$row],
            ':id' => $id
        ]);
        return self::find($id);
    }
}