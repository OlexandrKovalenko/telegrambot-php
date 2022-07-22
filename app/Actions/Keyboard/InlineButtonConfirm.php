<?php


namespace App\Actions\Keyboard;


class InlineButtonConfirm
{
    static function prepare($callback)
    {
        $data['confim'] = [
            [
                'text'=> hex2bin('E29C85')." Так",
                'callback' => $callback.'_accept',
            ],
            [
                'text'=> hex2bin('E29D8C').' Ні',
                'callback' => $callback.'_cancel',
            ],
        ];

        return $data;
    }

}