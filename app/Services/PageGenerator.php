<?php


namespace App\Services;


use App\Actions\BotLogger;
use App\Actions\Keyboard\InlineButtonConfirm;
use App\Actions\Keyboard\InlineButtonsForEditOffers;
use App\Actions\Keyboard\InlineButtonsForMyOffersList;
use App\Actions\Keyboard\InlineButtonsForMyProfile;
use App\Actions\Keyboard\InlineButtonsRegionSelector;
use Telegram\Bot\Api;

class PageGenerator
{
    static function generate(Api $telegram, $data, $menuData = null)
    {
        $menu = new MenuService($telegram, $data, $menuData);
        $menu->showButtons();
    }

    static function showCategories(Api $telegram, $data, $callback = null, $param = null)
    {
        $menu = new MenuService($telegram, $data);
        $menu->showButtons();
    }
}