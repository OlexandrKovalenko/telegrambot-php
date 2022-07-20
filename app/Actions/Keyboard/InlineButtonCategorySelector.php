<?php


namespace App\Actions\Keyboard;


use App\Database\Category;

class InlineButtonCategorySelector
{
    static function prepare($callback)
    {
        $category = new Category();
        $categories = $category->getAll();
        $data['category'] = [];

        isset($callback['offerSlug']) ? $offer = $callback['offerSlug'].'#' : $offer = null;
        for($i = 0; $i < count($categories); $i++)
        {
            $data['category'][$i] =
                [
                    'text'=> $categories[$i]->category,
                    'callback' => '@category#'.$callback['callback'].'#'.$offer.$categories[$i]->slug,
                ];
        }
        return $data;
    }

}