<?php


namespace App\Actions\CallbackActionCase;


use App\Services\OfferService;
use App\Services\TelegramSessionService;
use Telegram\Bot\Api;

class CaseUpdateMyOffer
{
    static function update(Api $telegram, $telegramId, $messageId, $data)
    {
        $offer = OfferService::showBySlug($data[2]);
        if ($offer->img != null)
        {
            $telegram->deleteMessage(['chat_id' => $telegramId, 'message_id' => $messageId]);
            $messageId = null;
        }
        switch ($data[1])
        {
            case 'region':
                CaseRegionShow::show($telegram, $telegramId, $messageId, $data);
                break;
            case 'category':
                CaseCategoryShow::show($telegram, $telegramId, $messageId, $data);
                break;
            case 'title':
                TelegramSessionService::setSession($telegramId, 'my_offer_store#title#'.$data[2]);
                $telegram->deleteMessage(['chat_id' => $telegramId, 'message_id' => $messageId]);
                $telegram->sendMessage(['chat_id' => $telegramId, 'parse_mode' => 'HTML', 'text' => 'Введіть заголовок запиту:']);
                break;
            case 'decription':
                TelegramSessionService::setSession($telegramId, 'my_offer_store#description#'.$data[2]);
                $telegram->deleteMessage(['chat_id' => $telegramId, 'message_id' => $messageId]);
                $telegram->sendMessage(['chat_id' => $telegramId, 'parse_mode' => 'HTML', 'text' => 'Введіть опис запиту:']);
                break;
            case 'contacts':
                TelegramSessionService::setSession($telegramId, 'my_offer_store#contacts#'.$data[2]);
                $telegram->deleteMessage(['chat_id' => $telegramId, 'message_id' => $messageId]);
                $telegram->sendMessage(['chat_id' => $telegramId, 'parse_mode' => 'HTML', 'text' => "Як з Вами зв'язатись?"]);
                break;
            case 'price':
                TelegramSessionService::setSession($telegramId, 'my_offer_store#price#'.$data[2]);
                $telegram->deleteMessage(['chat_id' => $telegramId, 'message_id' => $messageId]);
                $telegram->sendMessage(['chat_id' => $telegramId, 'parse_mode' => 'HTML', 'text' => 'Введіть ціну:']);
                break;
            case 'img':
                TelegramSessionService::setSession($telegramId, 'my_offer_store#img#'.$data[2]);
                $telegram->deleteMessage(['chat_id' => $telegramId, 'message_id' => $messageId]);
                $telegram->sendMessage(['chat_id' => $telegramId, 'parse_mode' => 'HTML', 'text' => 'Завантажте фото:']);
                break;
            case 'delete_img':
                if ($offer->img != null)
                {
                    TelegramSessionService::setSession($telegramId, 'my_offer_store_delete_photo');
                    OfferService::updateBySlug($data[2], ['img' => null]);
                }
                CaseEditMyOffer::edit($telegram, $telegramId, $data[2], $messageId);
                break;
            case 'activate':
                TelegramSessionService::setSession($telegramId, 'my_offer_store_activate');
                OfferService::updateBySlug($data[2], ['is_active' => true]);
                CaseEditMyOffer::edit($telegram, $telegramId, $data[2], $messageId);
                break;
            case 'deactivate':
                TelegramSessionService::setSession($telegramId, 'my_offer_store_deactivate');
                OfferService::updateBySlug($data[2], ['is_active' => false]);
                CaseEditMyOffer::edit($telegram, $telegramId, $data[2], $messageId);
                break;
            case 'delete':
                OfferService::destroyBySlug($data[2]);
                CaseMyOffers::show($telegram, $telegramId, $messageId);
                break;
        }
    }
}