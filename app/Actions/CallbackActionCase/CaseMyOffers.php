<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\Keyboard\InlineButtonsForMyOffersList;
use App\Actions\Page\MyOffersData;
use App\Database\User;
use App\Services\OfferService;
use App\Services\PageGenerator;
use App\Services\TelegramSessionService;
use Telegram\Bot\Api;

class CaseMyOffers
{
    static function show(Api $telegram, $telegramId, $messageId)
    {
        $user = new User();

        $offers = OfferService::getOffersByUserId($user->findByTelegramId($telegramId)->id);

        PageGenerator::generate($telegram, MyOffersData::generate($telegramId, $messageId, PrepareOffersData::prepare($offers)), InlineButtonsForMyOffersList::prepare(PrepareOffersData::prepare($offers)));
        TelegramSessionService::setSession($telegramId, 'my_offers');
    }

}