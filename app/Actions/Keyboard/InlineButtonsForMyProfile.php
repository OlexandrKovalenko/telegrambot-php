<?php


namespace App\Actions\Keyboard;


class InlineButtonsForMyProfile
{
    static function prepare()
    {
        $data['my_profile']= [
            [
                'text'=> hex2bin('E29C8F')." Ім'я",
                'callback' => '@update_name',
            ],
            [
                'text'=> hex2bin('E29C8F')." Прізвище",
                'callback' => '@update_lastName',
            ],
            [
                'text'=> hex2bin('E29C8F')." Телефон",
                'callback' => '@update_phone',
            ],
            [
                'text'=> hex2bin('E29C8F')." Категорія",
                'callback' => '@update_category',
            ],
            [
                'text'=> hex2bin('E29C8F')." Регіон",
                'callback' => '@update_region',
            ],
            [
                'text'=> hex2bin('F09F9383')." Ваші запити",
                'callback' => '@my_offers',
            ],
        ];
        return $data;
    }
}