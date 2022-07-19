<?php


namespace App\Database;


use PDO;

class Category
{
    private PDO $query;

    public function __construct()
    {
        $db = new DBConnect();
        $this->query = $db->connect();
    }

    function getAll()
    {
        $sql = "SELECT * FROM `categories`";
        $stmt = $this->query->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function getCategoryById($id)
    {
        $sql = "SELECT * FROM `categories` WHERE `id` = ?";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function getCategoryBySlug($slug)
    {
        $sql = "SELECT * FROM `categories` WHERE `slug` = ?";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function storeCategory($data)
    {
        $sql = "INSERT INTO `categories` (`category`, `slug`) VALUES (:category, :slug);";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([
            ':category'=> $data['name'],
            ':slug'=> $data['slug'],
        ]);
        return $this->query->lastInsertId();
    }

}