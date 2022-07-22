<?php

namespace App\Actions\Keyboard;


class CreateButtonKeyboard
{
    static function create($userSite): array
    {
        switch ($userSite){
            case 'start':
            case 'my_offers':
            return [
                    ['Головне меню', 'Мій профіль']
                ];
            case 'main_menu':
                return [
                    ['Мій профіль']
                ];
            case 'my_profile':
                return [
                    ['Головне меню']
                ];
        }
    }
}
