<?php

namespace App\Messages\Menu;


class CreateInLineKeyboard
{
    static function create($userSite): array
    {
        switch ($userSite){
            case 'my_profile':
                return array(
                    'inline_keyboard' => [
                        [
                            ['text' => hex2bin('F09F9383').'Ваши заявки', 'callback_data' => "updateAddress"],
                        ],
                        [
                            ['text' => hex2bin('E29C8F')."Имя", 'callback_data' => "updateName"],
                            ['text' => hex2bin('E29C8F').'Фамилия', 'callback_data' => "updateLastName"],
                            ['text' => hex2bin('E29C8F')."Телефон", 'callback_data' => "updatePhone"],
                        ],
                    ]
                );

            case 'catalog':
                return array(
                    'inline_keyboard' => []);
        }
    }
}