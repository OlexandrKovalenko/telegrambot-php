<?php


namespace App\Services;


use App\Database\User;

class UserService extends User
{
    static function checkUser($data)
    {
        $user = new User();
        if (!$user->findByTelegramId($data['id'])) {
            $user->create($data);
        }
    }

    static function showByTelegramId($tId)
    {
        $user = new User();
        return $user->findByTelegramId($tId);
    }
}