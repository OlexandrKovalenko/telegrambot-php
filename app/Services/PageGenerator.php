<?php


namespace App\Services;


use Telegram\Bot\Api;

class PageGenerator
{
    static function generate(Api $telegram, $data, $menuData = null)
    {
        $menu = new MenuService($telegram, $data, $menuData);
        $menu->showButtons();
    }
}