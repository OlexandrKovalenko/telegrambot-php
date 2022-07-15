<?php


namespace App\Messages\Menu;


use App\Botlogger\BotLogger;

class CreateOfferInlineKeyboard
{
    static function create($param)
    {
        $keyboard['inline_keyboard'] = [];
        $rows = intdiv(count($param), 2);
        $index = 0;
        if (!empty((array) $param))
        {
            $offerId = 1;
            for ($i = 0; $i < count($param); $i++)
            {
                if ($index == $rows)
                {
                    $keyboard['inline_keyboard'][$index] = [
                        ['text' => $offerId." - ".$param[$i]->callback, 'callback_data' => $param[$i]->callbackdata],
                    ];
                }
                else
                {
                    $keyboard['inline_keyboard'][$index] = [
                        ['text' => $offerId." - ".$param[$i]->callback, 'callback_data' => $param[$i]->callbackdata],
                        ['text' => $offerId+1 ." - ".$param[$i+1]->callback, 'callback_data' => $param[$i+1]->callbackdata]
                    ];
                    $i++;
                    $index++;
                    $offerId = $offerId + 2;
                }
            }

        }
        $keyboard['inline_keyboard'][$index] = [
            ['text' => hex2bin('E29E95')." Новая заявка", 'callback_data' => "@main_menu"],
            ['text' => " В главное меню... ", 'callback_data' => "@main_menu"]
            ];

        return $keyboard;
    }
}