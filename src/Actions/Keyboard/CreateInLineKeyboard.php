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
                            ['text' => "Сменить имя", 'callback_data' => "updateName"],
                            ['text' => 'Сменить фамилию', 'callback_data' => "updateLastName"],
                        ],
                        [
                            ['text' => "Сменить номер телефона", 'callback_data' => "updatePhone"],
                            ['text' => 'Сменить адресс доставки', 'callback_data' => "updateAddress"],
                        ],
                    ]
                );

            case 'catalog':
                return array(
                    'inline_keyboard' => []);
        }
    }
}