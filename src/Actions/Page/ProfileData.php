<?php


namespace App\Page;


class ProfileData
{
    static function generate($id, $user, $region)
    {
        $userSite = 'my_profile';
        $inLineMsg = "*Информация о пользователе:*\n\r*Имя:* {$user?->first_name}\n\r*Фамилия\:* {$user?->last_name}\n\r*Username:* @{$user?->username}\n\r*Регион:* {$region->city}, {$region->region} обл\. \n\r*Telegram ID:* {$user?->telegram_id}\n\r";
        return [
            'id'=>$id,
            'userSite'=>$userSite,
            //'botMessage'=>$botMessage,
            'inlineMsg'=>$inLineMsg
        ];
    }
}