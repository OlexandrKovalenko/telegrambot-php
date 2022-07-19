<?php


namespace App\Actions\Keyboard;


class InlineButtonsForEditOffers
{
    static function prepare($offer)
    {
        $data['my_offer_update'] = [
            [
                'text'=> hex2bin('E29C8F')." Регион",
                'callback' => "$offer->callbackdata#region#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Категория",
                'callback' => "$offer->callbackdata#category#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Названиие",
                'callback' => "$offer->callbackdata#title#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Описание",
                'callback' => "$offer->callbackdata#decription#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Фото",
                'callback' => "$offer->callbackdata#img#$offer->callback",
            ],            [
                'text'=> hex2bin('E29C8F')." Цена",
                'callback' => "$offer->callbackdata#price#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Контакты",
                'callback' => "$offer->callbackdata#contacts#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29D8C')." Удалить",
                'callback' => "$offer->callbackdata#delete#$offer->callback",
            ],
        ];
        return $data;

    }
}