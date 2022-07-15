<?php


namespace App\Messages;


use App\Botlogger\BotLogger;
use App\Database\Category;
use App\Database\Offer;
use App\Database\Region;
use App\Database\User;
use App\Messages\Menu\OfferService;
use App\Page\CategoriesData;
use App\Page\EditOfferData;
use App\Page\MainData;
use App\Page\MyOffersData;
use App\Page\PageGenerator;
use App\Page\ProfileData;
use App\Page\RegionData;
use App\TelegramSession\TelegramSessionService;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Button;
use Telegram\Bot\Keyboard\Keyboard;

class CallbackService
{
    private $telegramId, $messageId, $сallback_data;
    private Api $telegram;
    private mixed $getUser;
    private Region $region;
    private User $user;
    private Category $category;
    private mixed $getRegion;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
        $this->сallback_data = $this->telegram->getWebhookUpdate()['callback_query']['data'];
        $this->telegramId = $this->telegram->getWebhookUpdate()['callback_query']['from']['id'];
        $this->messageId = $this->telegram->getWebhookUpdate()->getMessage()->getMessageId();
        //$this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
        $this->user = new User();
        $this->getUser = $this->user->findByTelegramId($this->telegramId);
        $this->region = new Region();
        $this->getRegion = $this->region->getUserRegion($this->getUser->id);
        $this->category = new Category();
        $this->offer = new Offer();
    }

    function handler()
    {
        if (TelegramSessionService::getSession($this->telegramId)->last_activity === 'main_menu' )
        {
            $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => '<i>Время Вашей сессии уже истекло. Возвращаемся на главную.</i>']);
            PageGenerator::showMain($this->telegram, MainData::generate($this->telegramId));
        }
        switch ($this->сallback_data){
            case '@update_name_repeat':
            case '@update_name':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                TelegramSessionService::setSession($this->telegramId, 'update_name');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => 'Введите свое имя:']);
                break;
            case '@update_lastName_repeat':
            case '@update_lastName':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                TelegramSessionService::setSession($this->telegramId, 'update_lastName');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => 'Введите свою фамилию:']);
                break;

            case '@update_phone_repeat':
            case '@update_phone':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                TelegramSessionService::setSession($this->telegramId, 'update_phone');
                $button = Button::make(['text'=>"Поделиться контактом", 'request_contact'=>true]);
                $keyboard = [[$button]];
                $reply_markup = Keyboard::make(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true ]);

                $this->telegram->sendMessage([
                    'chat_id' => $this->telegramId,
                    'parse_mode' => 'HTML',
                    'text' => 'Предоставить свой номер телефона:',
                    'request_contact' => true,
                    'reply_markup' => $reply_markup]);
                break;
            case '@update_name_cancel':
            case '@update_lastName_cancel':
            case '@update_phone_cancel':
                PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->getUser, $this->getRegion, $this->messageId));
            break;
            case '@region_show':
            case '@update_region':
                $this->caseRegionShow();
                break;
            case (preg_match('/@region#.*/', $this->сallback_data) ? $this->сallback_data : null):
                $this->caseCityShow();
                break;
            case (preg_match('/@region_city#.*/', $this->сallback_data) ? $this->сallback_data : null):
                $this->caseCitySelected();
                break;
            case '@create_new_offer':
                //$this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => '*Ваши заявки:*']);
                //OfferService::create($this->getUser->id, $this->getRegion->located_city_id);
                //$this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
            case '@my_offers':
                $this->caseMyOffers();
                break;
            case (preg_match('/@my_offer_edit#.*/', $this->сallback_data) ? $this->сallback_data : null):
                $this->caseEditMyOffer();
                break;
            case (preg_match('/@my_offer_update#.*/', $this->сallback_data) ? $this->сallback_data : null):
                $this->caseUpdateMyOffer();
                break;
            case (preg_match('/@category#.*/', $this->сallback_data) ? $this->сallback_data : null):
                $this->caseCategory();
                break;
            case '@main_menu':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                //TelegramSessionService::setSession($this->telegramId, 'main_menu');
                $this->telegram->answerCallbackQuery([
                    'callback_query_id' => $this->telegram->getWebhookUpdate()['callback_query']['id'],
                    'text'=>'На главную...',
                    'show_alert'=> false,
                    'cache_time'=>1
                ]);
                PageGenerator::showMain($this->telegram, MainData::generate($this->telegramId));
                break;
            default:
        }
    }

    //TODO ACTIONS
    // Actions\caseRegionShow
    private function caseRegionShow($data = null)
    {
        if ($this->сallback_data === '@update_region')
        {
            TelegramSessionService::setSession($this->telegramId, 'select_my_region');
            PageGenerator::showRegion($this->telegram, RegionData::generate($this->telegramId, $this->messageId), 'profile_region');
        }
        elseif ($data[0] === '@my_offer_update' && $data[1] === 'region')
        {
            TelegramSessionService::setSession($this->telegramId, 'select_my_offer_region');
            PageGenerator::showRegion($this->telegram, RegionData::generate($this->telegramId, $this->messageId), "my_offer_region#$data[2]");
        }
    }

    private function caseCityShow()
    {
        $data = explode("#", $this->сallback_data);

        if ($data[1] === 'profile_region')
        {
            TelegramSessionService::setSession($this->telegramId, 'select_my_city');
            PageGenerator::showRegion($this->telegram, RegionData::generate($this->telegramId, $this->messageId, 'select_my_city'), 'profile_city', $data[2] );
        }
        elseif ($data[1] === 'my_offer_region')
        {
            TelegramSessionService::setSession($this->telegramId, 'select_my_offer_city');
            PageGenerator::showRegion($this->telegram, RegionData::generate($this->telegramId, $this->messageId, 'select_my_city'), "my_offer_city#$data[2]", $data[3] );
        }
    }

    private function caseCitySelected()
    {
        $data = explode("#", $this->сallback_data);
        if ($data[1] === 'profile_city')
        {
            $city = $this->region->getCityBySlug($data[2]);
            $this->getUser = $this->user->update($this->telegramId, ['located_city_id'=> $city->id]);
            $this->getRegion = $this->region->getUserRegion($this->getUser->id);
            PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->getUser, $this->getRegion, $this->messageId));

        }
        elseif ($data[1] === 'my_offer_city')
        {
            $city = $this->region->getCityBySlug($data[3]);
            $this->offer->updateOffer($this->offer->getOfferBySlug($data[2])->id, ['city_id' => $city->id]);
            $this->caseMyOffers();
        }
    }

    private function caseMyOffers()
    {
        $offers = OfferService::getOffersByUserId($this->getUser->id);

        PageGenerator::showMyOffers($this->telegram, MyOffersData::generate($this->telegramId, $this->messageId, $this->prepareOffersData($offers, '@my_offer_edit#')), $this->prepareOffersData($offers,'@my_offer_edit#'));
        TelegramSessionService::setSession($this->telegramId, 'my_offers');
    }

    private function caseEditMyOffer()
    {
        $data = explode("#", $this->сallback_data);
        $offer = OfferService::showBySlug($data[1]);

        if ($offer->user_id == $this->getUser->id)
        {
            $offer->city = $this->region->getCityById($offer->city_id)->city;
            $offer->category = $this->category->getCategoryById($offer->category_id)->category;
            $offer->callbackdata = '@my_offer_update#';
            $offer->msgId = $this->messageId;
            PageGenerator::EditOffer($this->telegram, EditOfferData::generate($this->telegramId, $offer), $offer);
        }
    }

    private function prepareOffersData($offers, $callback)
    {
        foreach ($offers as $offer)
        {
            $offer->city = $this->region->getCityById($offer->city_id)->city;
            $offer->category = $this->category->getCategoryById($offer->category_id)->category;
            $offer->callbackparam = $callback;
            $offer->callbackdata = $callback.$offer->callback;
        }
        return $offers;
    }

    private function caseUpdateMyOffer()
    {
        $data = explode("#", $this->сallback_data);

        switch ($data[1])
        {
            case 'region':
                $this->caseRegionShow($data);
                break;
            case 'category':
                $this->caseCategory();
                break;
        }
    }

    private function caseCategory($data = null)
    {
        $this->category->getAll();
        if ($data[0] === '@my_offer_update' && $data[1] === 'category')
        {
            PageGenerator::showRegion($this->telegram, CategoriesData::generate($this->telegramId, $this->messageId, 'select_my_offer_category'), 'profile_region', );

        }

    }
}