<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\BotLogger;
use App\Actions\Keyboard\InlineButtonsRegionSelector;
use App\Actions\Page\RegionData;
use App\Services\PageGenerator;
use App\Services\TelegramSessionService;
use Telegram\Bot\Api;

class CaseRegionShow
{
    static function show(Api $telegram, $telegramId, $messageId, $data)
    {
        if ($data[0] === '@update_region')
        {
            TelegramSessionService::setSession($telegramId, 'select_my_region');
            PageGenerator::generate($telegram, RegionData::generate($telegramId, $messageId),
                InlineButtonsRegionSelector::prepare(['type' => 'region', 'callback' => 'profile_region']));
        }
        elseif ($data[0] === '@my_offer_update' && $data[1] === 'region')
        {
            TelegramSessionService::setSession($telegramId, 'select_my_offer_region');
            PageGenerator::generate($telegram, RegionData::generate($telegramId, $messageId),
                InlineButtonsRegionSelector::prepare(['type' => 'region', 'callback' => "my_offer_region#$data[2]"]));
        }
    }
}