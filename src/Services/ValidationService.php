<?php


namespace App\Messages\Menu;


use App\Botlogger\BotLogger;

class ValidationService
{

    static function validateName($data)
    {
        $min = 2;
        $max = 13;
        $data = self::clean($data);
        $errors = [];
        if (self::check_length($data, $min, $max)) array_push($errors, self::check_length($data, $min, $max));
        if (self::checkForbiddenWords($data)) array_push($errors, self::checkForbiddenWords($data));

        if ($errors) return $errors;
        else return false;
    }

    static function validatePhone($data) {
        $check = function($phone)
        {
            if(strlen($phone) == 13 && mb_substr($phone, 0, 3) == '+38') return $phone;
            elseif(strlen($phone) == 12 && mb_substr($phone, 0, 1) == '3') return '+'.$phone;
            elseif(strlen($phone) == 11 && mb_substr($phone, 0, 1) == '8') return '+3'.$phone;
            elseif(strlen($phone) == 10 && mb_substr($phone, 0, 1) == '0') return '+38'.$phone;
            else return false;
        };
        $pattern = "/^\+380\d{3}\d{2}\d{2}\d{2}$/";
        if(preg_match($pattern, $check($data))) return true;
        else false;
    }


    private static function clean($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        return mb_strtolower($data);
    }

    private static function check_length($data, $min, $max) {
        if ((mb_strlen($data) < $min || mb_strlen($data) > $max)) return "<i>- Требуется от $min до $max символов</i>";
        else false;
    }

    // TODO migration in DB
    private static function checkForbiddenWords($data) {
        $arr = ['главное меню', 'мой профиль', 'главная', ];
        if (in_array($data, $arr)) return '<i>- Это не имя.</i>';
        else false;
    }
}