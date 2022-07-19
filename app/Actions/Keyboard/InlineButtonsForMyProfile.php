<?php


namespace App\Actions\Keyboard;


class InlineButtonsForMyProfile
{
    static function prepare()
    {
        $data['my_profile']= [
            [
                'text'=> hex2bin('E29C8F')." Имя",
                'callback' => '@update_name',
            ],
            [
                'text'=> hex2bin('E29C8F')." Фамилия",
                'callback' => '@update_lastName',
            ],
            [
                'text'=> hex2bin('E29C8F')." Телефон",
                'callback' => '@update_phone',
            ],
            [
                'text'=> hex2bin('E29C8F')." Категория",
                'callback' => '@update_category',
            ],
            [
                'text'=> hex2bin('E29C8F')." Регион",
                'callback' => '@update_region',
            ],
            [
                'text'=> hex2bin('F09F9383')." Ваши заявки",
                'callback' => '@my_offers',
            ],
        ];
        return $data;
    }
}