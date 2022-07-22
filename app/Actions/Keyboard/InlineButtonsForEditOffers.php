<?php


namespace App\Actions\Keyboard;


class InlineButtonsForEditOffers
{
    static function prepare($offer)
    {
        if ($offer->is_active)
        {
            $text = hex2bin('E29B94')." Деактивувати";
            $callback = "$offer->callbackdata#deactivate#$offer->callback";
        } else {
            $text = hex2bin('E29C85')." Активувати";
            $callback = "$offer->callbackdata#activate#$offer->callback";

        }
        $img = $offer->img != null;

        $data['my_offer_update'] = [
            [
                'text'=> hex2bin('E29C8F')." Регіон",
                'callback' => "$offer->callbackdata#region#$offer->callback",
                'img' => $img
            ],
            [
                'text'=> hex2bin('E29C8F')." Категорія",
                'callback' => "$offer->callbackdata#category#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Назва",
                'callback' => "$offer->callbackdata#title#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Опис",
                'callback' => "$offer->callbackdata#decription#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Фото",
                'callback' => "$offer->callbackdata#img#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Видалити фото",
                'callback' => "$offer->callbackdata#delete_img#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Ціна",
                'callback' => "$offer->callbackdata#price#$offer->callback",
            ],
            [
                'text'=> hex2bin('E29C8F')." Контакти",
                'callback' => "$offer->callbackdata#contacts#$offer->callback",
            ],
            [
                'text'=> $text,
                'callback' => $callback,
            ],
            [
                'text'=> hex2bin('E29D8C')." Видалити",
                'callback' => "$offer->callbackdata#delete#$offer->callback",
            ],
        ];
        return $data;

    }
}