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
        $inLineMsg = "<b>Информация о пользователе:</b> \n\r<b>Имя:</b> $user?->first_name \n\r<b>Фамилия:</b> $user?->last_name\n\r<b>Username:</b> @$user?->username\n\r<b>phone:</b> $user?->phone\n\r<b>Регион:</b> $region->city, $region->region\n\r<b>Категория:</b> $categoryName \n\r<b>Telegram ID:</b> $user?->telegram_id\n\r";
        return [
            'id'=>$id,
            'userSite'=>$userSite,
            //'botMessage'=>$botMessage,
            'inlineMsg'=>$inLineMsg,
            'msgId' => $msgId
        ];
    }
}