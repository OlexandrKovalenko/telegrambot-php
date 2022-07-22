<?php


namespace App\Services;



class ValidationService
{
    public int $min_length = 2;
    public int $max_length = 255;

    function validateText($data)
    {
        $data = $this->clean($data);
        $errors = [];
        if ($this->check_length($data, $this->min_length, $this->max_length)) array_push($errors, $this->check_length($data, $this->min_length, $this->max_length));
        if ($this->checkForbiddenWords($data)) array_push($errors, $this->checkForbiddenWords($data));

        if ($errors) return $errors;
        else return false;
    }

    function validatePhone($data) {
        $pattern = "/^\+380\d{3}\d{2}\d{2}\d{2}$/";
        if(preg_match($pattern, $this->phoneNumFixer($data))) return true;
        else false;
    }


    private function clean($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        return mb_strtolower($data);
    }

    private function check_length($data, $min, $max) {
        if ((mb_strlen($data) < $min || mb_strlen($data) > $max)) return "<i>- Необхідно ввести $min - $max символів</i>";
        else false;
    }

    // TODO migration in DB
    private function checkForbiddenWords($data) {
        $arr = ['главное меню', 'мой профиль', 'головне меню' ];
        if (in_array($data, $arr)) return '<i>- Это не имя.</i>';
        else false;
    }

    function phoneNumFixer($phone)
    {
        if(strlen($phone) == 13 && mb_substr($phone, 0, 3) == '+38') return $phone;
        elseif(strlen($phone) == 12 && mb_substr($phone, 0, 1) == '3') return '+'.$phone;
        elseif(strlen($phone) == 11 && mb_substr($phone, 0, 1) == '8') return '+3'.$phone;
        elseif(strlen($phone) == 10 && mb_substr($phone, 0, 1) == '0') return '+38'.$phone;
        else return null;
    }
}