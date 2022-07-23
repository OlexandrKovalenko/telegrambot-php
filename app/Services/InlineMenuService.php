<?php


namespace App\Services;



use App\Actions\BotLogger;

class InlineMenuService
{
    private string|int|null $menuName;
    private int $menuCount;

    public function __construct($data)
    {
        $this->menuName = key($data);
        $this->menuCount = count($data[key($data)]);
        $this->data = $data[key($data)];
    }

    function create() {

        $rowIndex = 0;
        $rows = intdiv(count($this->data), 2);
        $keyboard['inline_keyboard'] = [];

        if(!empty($this->data))
        {
            for ($i = 0; $i < count($this->data); $i++)
            {
                if ($rowIndex == $rows)
                {
                    $keyboard['inline_keyboard'][$rowIndex] = [['text' => $this->data[$i]['text'], 'callback_data' => $this->data[$i]['callback']]];
                }
                else
                {
                    $keyboard['inline_keyboard'][$rowIndex] = [
                        ['text' => $this->data[$i]['text'], 'callback_data' => $this->data[$i]['callback']],
                        ['text' => $this->data[$i+1]['text'], 'callback_data' => $this->data[$i+1]['callback']]
                    ];
                    $i++;
                }
                $rowIndex++;
            }
        }
        switch ($this->menuName)
        {
            case 'my_profile':
                $keyboard['inline_keyboard'][$rowIndex] = [
                    ['text' => "В головне меню... ".hex2bin('F09F9499'), 'callback_data' => "@main_menu"]
                ];
                break;
            case 'my_offers':
                $keyboard['inline_keyboard'][$rowIndex] = [
                    ['text' => hex2bin('E29E95')." Новий запит", 'callback_data' => "@create_new_offer"],
                    ['text' => " Профіль... " . hex2bin('F09F9499'), 'callback_data' => "@my_profile"],
                ];
                break;
            case 'my_offer_update':
                $this->data[0]['img'] != null ? $callback = '@my_offers_with_img' :  $callback = '@my_offers';
                $keyboard['inline_keyboard'][$rowIndex] = [
                    ['text' => hex2bin('F09F9499')." Назад", 'callback_data' => $callback],
                    ['text' => "В головне меню... ".hex2bin('F09F9499'), 'callback_data' => "@main_menu"]
                ];
                break;
            case 'category':
            case 'region':
                $keyboard['inline_keyboard'][$rowIndex] = [
                    ['text' => hex2bin('F09F9499')." Профіль... ", 'callback_data' => "@my_profile"],
                    ['text' => "В головне меню... ".hex2bin('F09F9499'), 'callback_data' => "@main_menu"]
                ];
                break;
        }
        return $keyboard;
    }
}