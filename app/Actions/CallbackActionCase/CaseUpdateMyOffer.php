<?php


namespace App\Actions\CallbackActionCase;


use App\Services\OfferService;
use App\Services\TelegramSessionService;
use Telegram\Bot\Api;

class CaseUpdateMyOffer
{
    static function update(Api $telegram, $telegramId, $messageId, $data)
    {
        switch ($data[1])
        {
            case 'region':
                CaseRegionShow::show($telegram, $telegramId, $messageId, $data);
                break;
            case 'category':
                CaseCategoryShow::show($telegram, $telegramId, $messageId, $data);
                break;
            case 'title':
                TelegramSessionService::setSession($telegramId, 'my_offer_update_title');
                break;
            case 'decription':
                TelegramSessionService::setSession($telegramId, 'my_offer_update_decription');
                break;
            case 'contacts':
                TelegramSessionService::setSession($telegramId, 'my_offer_update_contacts');

                break;
            case 'price':
                TelegramSessionService::setSession($telegramId, 'my_offer_update_price');

                break;
            case 'img':
                TelegramSessionService::setSession($telegramId, 'my_offer_update_img');

                break;
            case 'activate':
                TelegramSessionService::setSession($telegramId, 'my_offer_update_activate');
                OfferService::updateBySlug($data[2], ['is_active' => true]);
                CaseEditMyOffer::edit($telegram, $telegramId, $messageId, [null,$data[2]]);
                break;
            case 'deactivate':
                TelegramSessionService::setSession($telegramId, 'my_offer_update_deactivate');
                OfferService::updateBySlug($data[2], ['is_active' => false]);
                CaseEditMyOffer::edit($telegram, $telegramId, $messageId, [null,$data[2]]);
                break;
            case 'delete':
                OfferService::destroyBySlug($data[2]);
                CaseMyOffers::show($telegram, $telegramId, $messageId);
                break;
        }
    }
}