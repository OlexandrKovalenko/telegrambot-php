<?php


namespace App\Actions\Page;


class MyOffersData
{
    static function generate($id, $msgId, $data)
    {
        if (empty((array) $data))
        {
            $str = 'У вас ще немає запитів.';
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