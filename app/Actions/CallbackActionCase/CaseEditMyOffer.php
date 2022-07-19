<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\Keyboard\InlineButtonsForEditOffers;
use App\Actions\Page\EditOfferData;
use App\Database\Category;
use App\Database\Region;
use App\Database\User;
use App\Services\OfferService;
use App\Services\PageGenerator;
use Telegram\Bot\Api;

class CaseEditMyOffer
{
    static function edit(Api $telegram, $telegramId, $messageId, $data)
    {
        $user = new User();
        $region = new Region();
        $category = new Category();

        $offer = OfferService::showBySlug($data[1]);

        if ($offer->user_id == $user->findByTelegramId($telegramId)->id)
        {
            $offer->city = $region->getCityById($offer->city_id)->city;
            $offer->category = $category->getCategoryById($offer->category_id)->category;
            $offer->callbackdata = '@my_offer_update';
            $offer->msgId = $messageId;
            PageGenerator::generate($telegram, EditOfferData::generate($telegramId, $offer), InlineButtonsForEditOffers::prepare($offer));
        }
    }

}