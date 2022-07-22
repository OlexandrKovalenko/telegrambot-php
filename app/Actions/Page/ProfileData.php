<?php


namespace App\Actions\Page;


use App\Services\CategoryService;
use App\Services\RegionService;
use App\Services\UserService;

class ProfileData
{
    static function generate($id, $msgId = null)
    {
        $user = UserService::showByTelegramId($id);
        $categoryName = CategoryService::show($user->category_id)->category;
        $region = RegionService::regionByUserId($user->id);

        $userSite = 'my_profile';
        $inLineMsg = "<b>Дані користувача:</b> \n\r<b>Ім'я:</b> $user?->first_name \n\r<b>Прізвище:</b> $user?->last_name\n\r<b>Username:</b> @$user?->username\n\r<b>phone:</b> $user?->phone\n\r<b>Регіон:</b> $region->city, $region->region\n\r<b>Категорія:</b> $categoryName \n\r<b>Telegram ID:</b> $user?->telegram_id\n\r";
        return [
            'id'=>$id,
            'userSite'=>$userSite,
            //'botMessage'=>$botMessage,
            'inlineMsg'=>$inLineMsg,
            'msgId' => $msgId
        ];
    }
}