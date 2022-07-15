<?php

namespace App\Messages\Menu;


use App\Botlogger\BotLogger;

class CreateInLineKeyboard
{
    static function create($userSite, $callback, $param): array
    {
        switch ($userSite){
            case 'my_profile':
                return array(
                    'inline_keyboard' => [
                        [
                            ['text' => hex2bin('F09F9383')." Ваши заявки", 'callback_data' => "@my_offers"],
                        ],
                        [
                            ['text' => hex2bin('E29C8F')." Имя", 'callback_data' => "@update_name"],
                            ['text' => hex2bin('E29C8F')." Фамилия", 'callback_data' => "@update_lastName"],
                        ],
                        [
                            ['text' => hex2bin('E29C8F')." Регион", 'callback_data' => "@update_region"],
                            ['text' => hex2bin('E29C8F')." Телефон", 'callback_data' => "@update_phone"],
                        ],
                        [
                            ['text' => "В главное меню... ".hex2bin('F09F9499'), 'callback_data' => "@main_menu"],
                        ],
                    ]
                );
            case 'select_my_region':
            case 'edit_my_offer_select_region':
                return CreateRegionInlineKeyboard::create('region', $callback, $param);
            case 'select_my_city':
                return CreateRegionInlineKeyboard::create('city', $callback, $param);
            case 'confim_data':
                return array(
                    'inline_keyboard' => [
                        [
                            ['text' => hex2bin('E29C85')." Да", 'callback_data' => $callback.'_repeat'],
                            ['text' => hex2bin('E29D8C').' Нет', 'callback_data' => $callback.'_cancel'],
                        ],
                    ]
                );
            case 'my_offers':
                return CreateOfferInlineKeyboard::create($param);
            case 'my_offer_edit':
                return CreateEditMyOfferInlineKeyboard::create($param);
            case 'catalog':
                return array(
                    'inline_keyboard' => []);
        }
    }
}