<?php


namespace App\Actions;


use App\env;
use App\Services\FileStorageService;
use App\Services\OfferService;

class GetPhoto
{
    static function get($fileId, $offerSlug)
    {
        $key = env::TELEGRAMKEY;

        $request = file_get_contents("https://api.telegram.org/bot$key/getFile?file_id=$fileId");
        $responseData = json_decode($request, true);
        $img_path = $responseData['result']['file_path'];
        $img_url = "https://api.telegram.org/file/bot$key/$img_path";
        $img = "$offerSlug.jpg";
        copy($img_url, "storage/img/$img");
        if (FileStorageService::findImg($img)) OfferService::updateBySlug($offerSlug,['img' => $img]);
    }
}