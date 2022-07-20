<?php


namespace App\Services;


use App\Database\Region;

class RegionService
{
    static function regionByUserId($id)
    {
        $region = new Region();
        return $region->getUserRegion($id);
    }

    static function showCity($id)
    {
        $region = new Region();
        return $region->getCityById($id);
    }
}