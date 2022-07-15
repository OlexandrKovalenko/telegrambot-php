<?php


namespace App\Messages;


use App\Page\PageGenerator;
use App\Page\RegionData;
use App\TelegramSession\TelegramSessionService;
use Telegram\Bot\Api;

class CaseRegionShow
{
    static function caseRegionShow(Api $telegram, $telegramId, $сallback_data, $messageId )
    {
        if ($сallback_data === '@update_region')
        {
            TelegramSessionService::setSession($telegramId, 'select_my_region');
            PageGenerator::showRegion($telegram, RegionData::generate($telegramId, $messageId), 'profile_region');
        }
    }
}