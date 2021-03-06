<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\Keyboard\InlineButtonsForMyProfile;
use App\Actions\Page\ProfileData;
use App\Database\Offer;
use App\Database\Region;
use App\Database\User;
use App\Services\PageGenerator;
use Telegram\Bot\Api;

class CaseCitySelect
{
    static function select(Api $telegram, $telegramId, $messageId, $data)
    {
        $region = new Region();
        $user = new User();
        $offer = new Offer();

        if ($data[1] === 'profile_city')
        {
            $city = $region->getCityBySlug($data[2]);
            $user->update($telegramId, ['located_city_id'=> $city->id]);
            PageGenerator::generate($telegram, ProfileData::generate($telegramId, $messageId), InlineButtonsForMyProfile::prepare());

        }
        elseif ($data[1] === 'my_offer_city')
        {
            $city = $region->getCityBySlug($data[3]);
            $offer->updateOffer($offer->getOfferBySlug($data[2])->id, ['city_id' => $city->id]);
            $telegram->deleteMessage(['chat_id' => $telegramId, 'message_id' => $messageId]);
            CaseEditMyOffer::edit($telegram, $telegramId, $data[2]);
        }
    }

}