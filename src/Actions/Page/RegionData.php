<?php


namespace App\Page;


class RegionData
{
    static function generate($id, $msgId = null, $type = 'select_my_region')
    {
        $userSite = $type;
        $userSite == 'select_my_region' ? $inLineMsg = "Выберите область" : $inLineMsg = "Выберите город";
        return [
            'id' => $id,
            'userSite' => $userSite,
            'inlineMsg' => $inLineMsg,
            'msgId' => $msgId

        ];
    }
}