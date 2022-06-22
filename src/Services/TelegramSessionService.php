<?php


namespace App\TelegramSession;


use App\Botlogger\BotLogger;
use App\Database\TelegramSession;
use Carbon\Carbon;

class TelegramSessionService
{
    function getSession($id, $last_activity){
        $session = new TelegramSession();
        return self::check($session, $id) ? self::check($session, $id) : $session->create($id, $last_activity);
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
                $session->delete($id);
                return false;
            } else {
                return true;
            }
        }
    }
}