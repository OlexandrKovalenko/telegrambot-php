<?php


namespace App\Actions\Page;


use App\Actions\BotLogger;
use App\Services\FileStorageService;
use App\Services\OfferService;

class EditOfferData
{
    static function generate($id, $data)
    {
        $data->img && FileStorageService::findImg($data->img) ? $img = $data->img : $img = null;

        $userSite = 'my_offer_edit';
        $data->is_active ? $str = hex2bin('E29C85')." Активовано ".hex2bin('E29C85') : $str = hex2bin('E29B94')." Деактивовано".hex2bin('E29B94');
        $inLineMsg = "<b>Регіон:</b> ".$data->city."\n\r<b>Категорія:</b> ".$data->category."\n\r<b>Заголовок:</b> $data->title\n\r<b>Опис:</b> $data->description\n\r<b>Контакти:</b> $data->contacts\n\r<b>Ціна:</b> $data->price\n\r<b>Зображення:</b> $data->img\n\r<b>Статус: $str</b> \n\r";

        return [
            'id'=>$id,
            'userSite'=>$userSite,
            //'botMessage'=>$botMessage,
            'inlineMsg'=>$inLineMsg,
            'msgId' => $data->msgId,
            'photo' => $img
        ];
    }

}