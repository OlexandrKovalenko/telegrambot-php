<?php


namespace App\Actions\Page;


class RegionData
{
    static function generate($id, $msgId = null, $type = 'select_my_region')
    {
        $userSite = $type;
        $userSite == 'select_my_region' ? $inLineMsg = "Обрати область" : $inLineMsg = "Обрати місто";
        return [
            'id' => $id,
            'userSite' => $userSite,
            'inlineMsg' => $inLineMsg,
            'msgId' => $msgId

        ];
    }
}