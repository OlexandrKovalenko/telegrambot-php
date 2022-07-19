<?php


namespace App\Actions\Page;


class CategoriesData
{
    static function generate($id, $msgId, $userSite)
    {
        $inLineMsg = "Выберите категорию:";
        return [
            'id' => $id,
            'userSite' => $userSite,
            'inlineMsg' => $inLineMsg,
            'msgId' => $msgId

        ];
    }
}