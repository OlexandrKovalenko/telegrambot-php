<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\BotLogger;
use App\Actions\Keyboard\InlineButtonsForEditOffers;
use App\Actions\Page\EditOfferData;
use App\Services\CategoryService;
use App\Services\FileStorageService;
use App\Services\OfferService;
use App\Services\PageGenerator;
use App\Services\RegionService;
use App\Services\UserService;
use Telegram\Bot\Api;

class CaseEditMyOffer
{
    static function edit(Api $telegram, $telegramId, $slug, $messageId = null)
    {
        $offer = OfferService::showBySlug($slug);
        if ($offer->img != null)
        {
            FileStorageService::findImg($slug) ? $telegram->deleteMessage(['chat_id' => $telegramId, 'message_id' => $messageId]) : OfferService::updateBySlug($slug, ['img' => null]);
        }
        if ($offer->user_id == UserService::showByTelegramId($telegramId)->id)
        {
            $offer->city = RegionService::showCity($offer->city_id)->city;
            $offer->category = CategoryService::show($offer->category_id)->category;
            $offer->callbackdata = '@my_offer_update';
            $offer->msgId = $messageId;
            PageGenerator::generate($telegram, EditOfferData::generate($telegramId, $offer), InlineButtonsForEditOffers::prepare($offer));
        }
    }

}