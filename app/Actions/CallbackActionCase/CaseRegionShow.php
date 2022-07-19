<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\Keyboard\InlineButtonsRegionSelector;
use App\Actions\Page\RegionData;
use App\Services\PageGenerator;
use App\Services\TelegramSessionService;
use Telegram\Bot\Api;

class CaseRegionShow
{
    static function caseRegionShow(Api $telegram, $telegramId, $сallback_data, $messageId )
    {
        if ($сallback_data === '@update_region')
        {
            TelegramSessionService::setSession($telegramId, 'select_my_region');
            PageGenerator::generate($telegram, RegionData::generate($telegramId, $messageId),
                InlineButtonsRegionSelector::prepare(['type' => 'region', 'callback' => 'profile_region']));
        }
    }
}