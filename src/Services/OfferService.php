<?php


namespace App\Messages\Menu;


use App\Botlogger\BotLogger;
use App\Database\Offer;
use Carbon\Carbon;

class OfferService
{
    function showMyNewOffer($uid, $city)
    {

    }

    static function create($uid, $city) {
        $offer = new Offer();
        $data = [
            'uid' => $uid,
            'city' => $city,
            'date' => Carbon::now(),
            'callback' => strtoupper(base_convert(strval($uid.'#'.$city.'#'.Carbon::now()),10,34)),
        ];
        return $offer->storeOffer($data);
    }

    static function getOffersByUserId($uid){
        $offer = new Offer();
        return $offer->getOfferByUser($uid);
    }

    static function showBySlug($slug)
    {
        $offer = new Offer();
        return $offer->getOfferBySlug($slug);

    }

    private function issetEmptyUserOffer($uid)
    {
        $offer = new Offer();
    }


}