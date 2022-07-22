<?php


namespace App\Actions\TextMessageActionCase;


use App\Actions\BotLogger;
use App\Services\OfferService;

class TextMessageCaseUpdateMyOfferData
{
    static function update($data, $text)
    {
        return OfferService::updateBySlug($data[2], [$data['row'] => $text]);
    }
}