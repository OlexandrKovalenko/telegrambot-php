<?php


namespace App\Page;


class MyOffersData
{
    static function generate($id, $msgId, $data)
    {
        if (empty((array) $data))
        {
            $str = 'У вас нет заявок.';
        }
        else
        {
            $str = null;
            $i = 1;
            foreach ($data as $el)
            {
                $str .= "<b>$i - </b> $el->title ($el->city / $el->category) <i>$el->callback</i>".PHP_EOL;
                $i++;
            }
        }

        $userSite = 'my_offers';
        $inLineMsg = $str;
        return [
            'id'=>$id,
            'userSite'=>$userSite,
            'inlineMsg'=>$inLineMsg,
            'msgId' => $msgId
        ];
    }
}