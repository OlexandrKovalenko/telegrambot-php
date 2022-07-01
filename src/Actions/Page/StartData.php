<?php


namespace App\Page;


class StartData
{
    static function generate($id)
    {
        $userSite = 'start';
        $botMessage = "This is \- START";
        return [
            'id'=>$id,
            'userSite'=>$userSite,
            'botMessage'=>$botMessage
        ];
    }
}