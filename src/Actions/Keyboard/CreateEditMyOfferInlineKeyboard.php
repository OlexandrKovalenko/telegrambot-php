<?php


namespace App\Messages\Menu;


use App\Botlogger\BotLogger;

class CreateEditMyOfferInlineKeyboard
{
    static function create($callback)
    {
        if ($callback->is_active) $activateBtn = ['text' => hex2bin('E29C85')." Активировать", 'callback_data' => $callback->callbackdata."activate#".$callback->callback];
        else $activateBtn = ['text' => hex2bin('E29B94')." Деактивировать", 'callback_data' => $callback->callbackdata."activate#".$callback->callback];
        return array(
            'inline_keyboard' => [
                [
                    ['text' => hex2bin('E29C8F')."Регион", 'callback_data' => $callback->callbackdata."region#".$callback->callback],
                    ['text' => hex2bin('E29C8F')." Категория", 'callback_data' => $callback->callbackdata."category#".$callback->callback],
                ],
                [
                    ['text' => hex2bin('E29C8F')." Названиие", 'callback_data' => $callback->callbackdata."title#".$callback->callback],
                    ['text' => hex2bin('E29C8F')." Описание", 'callback_data' => $callback->callbackdata."decription#".$callback->callback],
                ],
                [
                    ['text' => hex2bin('E29C8F')." Фото", 'callback_data' => $callback->callbackdata."img#".$callback->callback],
                    ['text' => hex2bin('E29C8F')." Цена", 'callback_data' => $callback->callbackdata."price#".$callback->callback],
                    ['text' => hex2bin('E29C8F')." Контакты", 'callback_data' => $callback->callbackdata."contacts#".$callback->callback],
                ],
                [
                    $activateBtn,
                    ['text' => hex2bin('E29D8C')." Удалить", 'callback_data' => $callback->callbackdata."delete#".$callback->callback],

                ],
                [
                    ['text' => hex2bin('F09F9499')." Назад", 'callback_data' => "@my_offers"],
                    ['text' => "В главное меню... ".hex2bin('F09F9499'), 'callback_data' => "@main_menu"],
                ],
            ]
        );

    }
}