<?php


namespace App\Actions;


use App\Database\DBConnect;
use Carbon\Carbon;

class BotLogger
{
    static function
    store($data)
    {
        $currentDate = Carbon::now();
        file_put_contents('log.txt',
            'Date '.$currentDate.PHP_EOL.'Data: '.print_r($data, 1).PHP_EOL);
    }

}