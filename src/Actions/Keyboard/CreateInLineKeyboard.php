<?php

namespace App\Messages\Menu;


class CreateInLineKeyboard
{
    static function create($userSite, $param): array
    {
        switch ($userSite){
            case 'my_profile':
                return array(
                    'inline_keyboard' => [
                        [
                            ['text' => hex2bin('F09F9383').'Ваши заявки', 'callback_data' => "@my_offers"],
                        ],
                        [
                            ['text' => hex2bin('E29C8F')."Имя", 'callback_data' => "@update_name"],
                            ['text' => hex2bin('E29C8F').'Фамилия', 'callback_data' => "@update_lastName"],
                        ],
                        [
                            ['text' => hex2bin('E29C8F').'Регион', 'callback_data' => "@update_region"],
                            ['text' => hex2bin('E29C8F')."Телефон", 'callback_data' => "@update_phone"],
                        ],
                        [
                            ['text' => hex2bin('F09F9383')."В главное меню...".hex2bin('F09F9499'), 'callback_data' => "@main_menu"],
                        ],
                    ]
                );
            case 'select_my_region':
                return CreateRegionInlineKeyboard::create('region');
            case 'select_my_city':
                return CreateRegionInlineKeyboard::create('city', $param);
            case 'catalog':
                return array(
                    'inline_keyboard' => []);
            case 'confim_data':
                return array(
                    'inline_keyboard' => [
                        [
                            ['text' => hex2bin('E29C85')." Да", 'callback_data' => $param.'_repeat'],
                            ['text' => hex2bin('E29D8C').' Нет', 'callback_data' => $param.'_cancel'],
                        ],
                    ]
                );
        }
    }
}