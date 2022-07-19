<?php


namespace App\Actions\Keyboard;


class InlineButtonConfirm
{
    static function prepare($callback)
    {
        $data['confim'] = [
            [
                'text'=> hex2bin('E29C85')." Да",
                'callback' => $callback.'_accept',
            ],
            [
                'text'=> hex2bin('E29D8C').' Нет',
                'callback' => $callback.'_cancel',
            ],
        ];

        return $data;
    }

}