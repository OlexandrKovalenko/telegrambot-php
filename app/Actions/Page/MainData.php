<?php


namespace App\Actions\Page;


class MainData
{
    static function generate($id)
    {
        $userSite = 'main_menu';
        $botMessage = "This is \- *Головне меню*";
        return [
            'id'=>$id,
            'userSite'=>$userSite,
            'botMessage'=>$botMessage,
        ];
    }
}