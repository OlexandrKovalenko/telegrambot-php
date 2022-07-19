<?php


namespace App\Actions\Keyboard;


class InlineButtonsForMyOffersList
{
    static function prepare($offers)
    {
        $data['my_offers'] = [];

        $index = 1;
        if (!empty((array) $offers))
        {
            for ($i = 0; $i < count($offers); $i++)
            {
                $data['my_offers'][$i] =
                    [
                        'text'=> $index.' - '.$offers[$i]->callback,
                        'callback' => '@my_offer_edit#'.$offers[$i]->callback,
                    ];
                $index++;
            }
        }

        return $data;
    }
}