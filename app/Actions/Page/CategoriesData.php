<?php


namespace App\Actions\Page;


class CategoriesData
{
    static function generate($id, $msgId, $userSite)
    {
        $inLineMsg = "Обрати категорію:";
        return [
            'id' => $id,
            'userSite' => $userSite,
            'inlineMsg' => $inLineMsg,
            'msgId' => $msgId

        ];
    }
}