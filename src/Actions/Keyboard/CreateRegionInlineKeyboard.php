<?php


namespace App\Messages\Menu;


use App\Botlogger\BotLogger;
use App\Database\Region;

class CreateRegionInlineKeyboard
{
    static function create($type, $param = null)
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

        $keyboard['inline_keyboard'] = [];

        if ($type === 'region')
        {
            for($i = 0; $i < count($arr); $i++)
            {
                $keyboard['inline_keyboard'][$i] = [
                    ['text' => $arr[array_keys($arr)[$i]][0]['region'], 'callback_data' => "@my_region_#".array_keys($arr)[$i]]
                ];
            }
            $keyboard['inline_keyboard'][count($keyboard['inline_keyboard'])] = [
                ['text' => hex2bin('F09F9383')."В главное меню...".hex2bin('F09F9499'), 'callback_data' => "@main_menu"]
            ];
        }
        elseif ($type === 'city') {
            $rows = intdiv(count($arr[$param]), 2);
            $index = 0;
            for ($i = 0; $i<count($arr[$param]); $i++)
            {
                if ($index == $rows)
                {
                    $keyboard['inline_keyboard'][$index] = [
                        ['text' => $arr[$param][$i]['city'], 'callback_data' => "@my_region_city_#".$arr[$param][$i]['city_slug']],
                        ['text' => hex2bin('F09F9383')."В главное меню...".hex2bin('F09F9499'), 'callback_data' => "@main_menu"]
                    ];
                }
                else
                {
                    $keyboard['inline_keyboard'][$index] = [
                        ['text' => $arr[$param][$i]['city'], 'callback_data' => "@my_region_city_#".$arr[$param][$i]['city_slug']],
                        ['text' => $arr[$param][$i+1]['city'], 'callback_data' => "@my_region_city_#".$arr[$param][$i+1]['city_slug']]
                    ];
                    $i++;
                    $index++;
                }
            }
        }
        return $keyboard;
    }
}