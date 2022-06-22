<?php

namespace App\Database;


use App\Database\DBConnect;
use Carbon\Carbon;
use PDO;

class TelegramSession
{
    private PDO $query;

    public function __construct()
    {
        $db = new DBConnect();
        $this->query = $db->connect();
    }

    function find($telegram_id)
    {
        $stmt = $this->query->prepare('SELECT * FROM session where telegram_id = ?');
        $stmt->execute([$telegram_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function create($telegram_id, $last_activity)
    {
        $stmt = $this->query->prepare(
            "INSERT INTO session (telegram_id, last_activity) values (:id, :last_activity)"
        );
        $stmt->execute([
            ':id' => $telegram_id,
            ':last_activity' => $last_activity
        ]);
        return self::find($telegram_id);
    }

    function update($telegram_id, $last_activity)
    {
        $stmt = $this->query->prepare("UPDATE session SET last_activity=:last_activity, updated_at=:updated_at WHERE telegram_id=:id");
        $stmt->execute([
            ':id' => $telegram_id,
            ':last_activity' => $last_activity,
            'updated_at' => Carbon::now()->timezone('Europe/Kiev')
        ]);
        return self::find($telegram_id);
    }

    function delete($telegram_id)
    {
        $stmt = $this->query->prepare("DELETE FROM session WHERE telegram_id=?");
        $stmt->execute([$telegram_id]);
    }
}