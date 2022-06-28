<?php


namespace App\Page;


use App\Botlogger\BotLogger;

class ProfileData
{
    static function generate($id, $user)
    {
        $userSite = 'my_profile';
        $inLineMsg = "*Информация о пользователе:*\n\r*Имя:* {$user?->first_name}\n\r*Фамилия\:* {$user?->last_name}\n\r*Username:* @{$user?->username}\n\r*Telegram ID:* {$user?->telegram_id}";
        //$botMessage = "";
        return [
            'id'=>$id,
            'userSite'=>$userSite,
            //'botMessage'=>$botMessage,
            'inlineMsg'=>$inLineMsg
        ];
    }
}