<?php


namespace App\Actions\CallbackActionCase;


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
        }
    }
}