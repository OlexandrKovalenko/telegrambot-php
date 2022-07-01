<?php


namespace App\Page;


use App\Botlogger\BotLogger;
use App\Messages\Menu\MenuService;
use Telegram\Bot\Api;

class PageGenerator
{
    static function showStart(Api $telegram, $data)
    {
        $menu = new MenuService($telegram, $data);
        $menu->showButtons();
    }

    static function showMain(Api $telegram, $data)
    {
        $menu = new MenuService($telegram, $data);
        $menu->showButtons();
    }

    static function showProfile(Api $telegram, $data)
    {
        $menu = new MenuService($telegram, $data);
        $menu->showButtons();
    }

    static function showRegion(Api $telegram, $data, $callback = null, $param = null)
    {
        $menu = new MenuService($telegram, $data);
        $menu->showButtons($callback, $param);
    }
    static function showConfirm(Api $telegram, $data, $callback)
    {
        $menu = new MenuService($telegram, $data);
        $menu->showButtons($callback);
    }
}