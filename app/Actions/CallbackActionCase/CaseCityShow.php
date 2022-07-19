<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\Keyboard\InlineButtonsRegionSelector;
use App\Actions\Page\RegionData;
use App\Services\PageGenerator;
use App\Services\TelegramSessionService;
use Telegram\Bot\Api;

class CaseCityShow
{
    static function show(Api $telegram, $telegramId, $messageId, $data)
    {
        if ($data[1] === 'profile_region')
        {
            TelegramSessionService::setSession($telegramId, 'select_my_city');
            PageGenerator::generate($telegram, RegionData::generate($telegramId, $messageId, 'select_my_city'),
                InlineButtonsRegionSelector::prepare(['type' => 'city', 'callback' => 'profile_city', 'citySlug' => $data[2]]));
        }
        elseif ($data[1] === 'my_offer_region')
        {
            TelegramSessionService::setSession($telegramId, 'select_my_offer_city');
            PageGenerator::generate($telegram, RegionData::generate($telegramId, $messageId, 'select_my_city'),
                InlineButtonsRegionSelector::prepare(['type' => 'city', 'callback' => 'my_offer_city', 'offerSlug' => $data[2], 'citySlug' => $data[3]]));
        }
    }

}