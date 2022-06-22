<?php

namespace App\Messages\Menu;


class CreateButtonKeyboard
{
    static function create($userSite): array
    {
        switch ($userSite){
            case 'start':
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
