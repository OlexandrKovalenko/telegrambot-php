<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\Keyboard\InlineButtonsForMyProfile;
use App\Actions\Page\ProfileData;
use App\Database\Category;
use App\Database\Offer;
use App\Database\Region;
use App\Database\User;
use App\Services\PageGenerator;
use Telegram\Bot\Api;

class CaseCategorySelect
{
    static function select(Api $telegram, $telegramId, $messageId, $data)
    {
        $category = new Category();

        switch ($data[1])
        {
            case 'select_my_offer_category';
                $offer = new Offer();
                $offer->updateOffer($offer->getOfferBySlug($data[2])->id, ['category_id' => $category->getCategoryBySlug($data[3])->id]);
                CaseMyOffers::show($telegram, $telegramId, $messageId);
                break;
            case 'select_my_category':
                $user = new User();
                $region = new Region();

                $user->update($telegramId, ['category_id'=>$category->getCategoryBySlug($data[2])->id]);
                $getUser = $user->findByTelegramId($telegramId);
                PageGenerator::generate($telegram, ProfileData::generate($telegramId, $getUser, $region->getUserRegion($getUser->id), $messageId), InlineButtonsForMyProfile::prepare());
                break;
        }
    }

}