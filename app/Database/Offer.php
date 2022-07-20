<?php


namespace App\Database;


use PDO;
use PDOException;

class Offer
{

    private PDO $query;

    public function __construct()
    {
        $db = new DBConnect();
        $this->query = $db->connect();
    }

    function getAll()
    {
        $sql = "SELECT * FROM `offers`";
        $stmt = $this->query->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function getOfferBySlug($callback)
    {
        $sql = "SELECT * FROM `offers` WHERE `callback` = ?";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([$callback]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function getOfferById($id)
    {
        $sql = "SELECT * FROM `offers` WHERE `id` = ?";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function getOfferByUser($uid)
    {
        $sql = "SELECT * FROM `offers` WHERE `user_id` = ? ORDER BY `created_at` ASC";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([$uid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function storeOffer($data)
    {
        try {
            $sql = "INSERT INTO `offers` (`user_id`, `city_id`, `category_id`, `title`, `description`, `img`, `contacts`, `price`, `is_active`, `callback`, `created_at`, `updated_at`) 
VALUES (:uid, :city, '1', '%empty%', '%empty%', '%empty%', '%empty%', '%empty%', '0', :callback , :date, CURRENT_TIMESTAMP);";
            $stmt = $this->query->prepare($sql);
            $stmt->execute([
                ':uid'=> $data['uid'],
                ':city'=> $data['city'] ?? 462,
                ':callback'=> $data['callback'],
                ':date'=> $data['date'],
            ]);
            return $this->query->lastInsertId();
        } catch(PDOException $e) {
        }

    }

    function updateOffer($id, $data)
    {
        $row = key($data);
        $sql = "UPDATE offers SET $row=:data WHERE id=:id";
        $stmt = $this->query->prepare($sql);
        $stmt->execute([
            ':data' => $data[$row],
            ':id' => $id
        ]);
        return self::getOfferById($id);
    }

    function deleteOffer($id)
    {
        return $this->query->prepare("DELETE FROM offers WHERE id=?")->execute([$id]);
    }

}