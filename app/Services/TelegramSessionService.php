<?php


namespace App\Services;


use App\Database\TelegramSession;
use Carbon\Carbon;

class TelegramSessionService
{
    static function getSession($id){
        $session = new TelegramSession();
        return self::check($session, $id) ? self::check($session, $id) : $session->create($id);
    }

    static function setSession($id, $last_activity)
    {
        $session = new TelegramSession();

        if (self::check($session, $id))  return $session->update($id, $last_activity);
        else return $session->create($id, $last_activity);
    }

    static function check(TelegramSession $session, $id)
    {
        if($session->find($id))
        {
            if ($session->find($id)->updated_at < Carbon::now()->timezone('Europe/Kiev')->subHour())
            {
                return $session->update($id, 'main_menu');
            } else {
                return $session->find($id);
            }
        }
    }
}