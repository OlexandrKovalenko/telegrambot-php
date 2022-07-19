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
                    ['Главное меню', 'Мой профиль']
                ];
            case 'main_menu':
                return [
                    ['Мой профиль']
                ];
            case 'my_profile':
                return [
                    ['Главное меню']
                ];
        }
    }
}
