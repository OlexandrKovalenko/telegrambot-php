<?php


namespace App\Actions\Keyboard;


use App\Actions\BotLogger;
use App\Database\Region;

class InlineButtonsRegionSelector
{

    static function prepare($callback)
    {
        $region = new Region();
        $arr = [];
        foreach ($region->getActiveCities() as $el)
        {
            if (array_key_exists($el->region_slug, $arr)){
                $arr[$el->region_slug][count($arr[$el->region_slug])] = ['region'=>$el->region, 'city'=>$el->city, 'city_slug' => $el->city_slug];
            }
            else {
                $arr[$el->region_slug][0] = [
                    'region'=>$el->region,
                    'city'=>$el->city,
                    'city_slug' => $el->city_slug
                ];
            }
        }

        $data['region'] = [];

        if ($callback['type'] === 'region')
        {
            for($i = 0; $i < count($arr); $i++)
            {
                $data['region'][$i] =
                    [
                        'text'=> $arr[array_keys($arr)[$i]][0]['region'],
                        'callback' => '@region#'.$callback['callback'].'#'.array_keys($arr)[$i],
                    ];
            }
        }
        elseif ($callback['type'] === 'city')
        {
            isset($callback['offerSlug']) ? $offer = $callback['offerSlug'].'#' : $offer = null;

            for ($i = 0; $i<count($arr[$callback['citySlug']]); $i++)
            {
                $data['region'][$i] =
                    [
                        'text'=> $arr[$callback['citySlug']][$i]['city'],
                        'callback' => '@region_city#'.$callback['callback'].'#'.$offer.$arr[$callback['citySlug']][$i]['city_slug'],
                    ];
            }
        }
        return $data;
    }
}