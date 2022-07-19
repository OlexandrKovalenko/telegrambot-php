<?php


namespace App\Actions\CallbackActionCase;


use App\Database\Category;
use App\Database\Region;

class PrepareOffersData
{
    static function prepare($offers)
    {
        $region = new Region();
        $category = new Category();

        foreach ($offers as $offer)
        {
            $offer->city = $region->getCityById($offer->city_id)->city;
            $offer->category = $category->getCategoryById($offer->category_id)->category;
        }
        return $offers;
    }

}