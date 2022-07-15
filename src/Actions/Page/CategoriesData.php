<?php


namespace App\Page;


class CategoriesData
{
    static function generate($id, $msgId = null, $userSite)
    {
        $inLineMsg = "Выберите категорию";
        return [
            'id' => $id,
            'userSite' => $userSite,
            'inlineMsg' => $inLineMsg,
            'msgId' => $msgId

        ];
    }
}