<?php


namespace App\Actions\CallbackActionCase;


use App\Actions\BotLogger;
use App\Actions\Keyboard\InlineButtonCategorySelector;
use App\Actions\Page\CategoriesData;
use App\Database\Category;
use App\Services\PageGenerator;
use Telegram\Bot\Api;

class CaseCategoryShow
{
    static function show(Api $telegram, $telegramId, $messageId, $data)
    {
        $category = new Category();

        $category->getAll();
        if ($data[0] === '@my_offer_update' && $data[1] === 'category')
        {
            PageGenerator::generate($telegram, CategoriesData::generate($telegramId, $messageId, 'select_my_offer_category'), InlineButtonCategorySelector::prepare(['callback' => 'select_my_offer_category', 'offerSlug' => $data[2]]));
        } elseif($data[0] === '@update_category') {
            PageGenerator::generate($telegram, CategoriesData::generate($telegramId, $messageId, 'select_my_category'), InlineButtonCategorySelector::prepare(['callback' => 'select_my_category']));
        }
    }

}