<?php


namespace App\Services;


use App\Actions\BotLogger;
use App\Actions\Keyboard\InlineButtonsForEditOffers;
use App\Actions\Keyboard\InlineButtonsForMyOffersList;
use App\Actions\Keyboard\InlineButtonsForMyProfile;
use App\Actions\Keyboard\InlineButtonsRegionSelector;
use App\Actions\Page\CategoriesData;
use App\Actions\Page\EditOfferData;
use App\Actions\Page\MainData;
use App\Actions\Page\MyOffersData;
use App\Actions\Page\ProfileData;
use App\Actions\Page\RegionData;
use App\Database\Category;
use App\Database\Offer;
use App\Database\Region;
use App\Database\User;
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
        //BotLogger::store($this->сallback_data);
        if (TelegramSessionService::getSession($this->telegramId)->last_activity === 'main_menu' )
        {
            $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => '<i>Время Вашей сессии уже истекло. Возвращаемся на главную.</i>']);
            PageGenerator::generate($this->telegram, MainData::generate($this->telegramId));
        }
        switch ($this->сallback_data){
            case '@update_phone_cancel':
            case '@update_lastName_cancel':
            case '@update_name_cancel':
            case '@my_profile':
                PageGenerator::generate($this->telegram, ProfileData::generate($this->telegramId, $this->getUser, $this->getRegion, $this->messageId), InlineButtonsForMyProfile::prepare());
                break;
            case '@update_name_accept':
            case '@update_name':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                TelegramSessionService::setSession($this->telegramId, 'update_name');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => 'Введите свое имя:']);
                break;
            case '@update_lastName_accept':
            case '@update_lastName':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                TelegramSessionService::setSession($this->telegramId, 'update_lastName');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => 'Введите свою фамилию:']);
                break;

            case '@update_phone_accept':
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
                PageGenerator::generate($this->telegram, MainData::generate($this->telegramId));
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
            PageGenerator::generate($this->telegram, RegionData::generate($this->telegramId, $this->messageId),
                InlineButtonsRegionSelector::prepare(['type' => 'region', 'callback' => 'profile_region']));
        }
        elseif ($data[0] === '@my_offer_update' && $data[1] === 'region')
        {
            TelegramSessionService::setSession($this->telegramId, 'select_my_offer_region');
            PageGenerator::generate($this->telegram, RegionData::generate($this->telegramId, $this->messageId),
                InlineButtonsRegionSelector::prepare(['type' => 'region', 'callback' => "my_offer_region#$data[2]"]));
        }
    }

    private function caseCityShow()
    {
        $data = explode("#", $this->сallback_data);

        if ($data[1] === 'profile_region')
        {
            TelegramSessionService::setSession($this->telegramId, 'select_my_city');
            PageGenerator::generate($this->telegram, RegionData::generate($this->telegramId, $this->messageId, 'select_my_city'),
                InlineButtonsRegionSelector::prepare(['type' => 'city', 'callback' => 'profile_city', 'citySlug' => $data[2]]));
        }
        elseif ($data[1] === 'my_offer_region')
        {
            TelegramSessionService::setSession($this->telegramId, 'select_my_offer_city');
            PageGenerator::generate($this->telegram, RegionData::generate($this->telegramId, $this->messageId, 'select_my_city'),
                InlineButtonsRegionSelector::prepare(['type' => 'city', 'callback' => 'my_offer_city', 'offerSlug' => $data[2], 'citySlug' => $data[3]]));
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
            PageGenerator::generate($this->telegram, ProfileData::generate($this->telegramId, $this->getUser, $this->getRegion, $this->messageId), InlineButtonsForMyProfile::prepare());

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

        PageGenerator::generate($this->telegram, MyOffersData::generate($this->telegramId, $this->messageId, $this->prepareOffersData($offers)), InlineButtonsForMyOffersList::prepare($this->prepareOffersData($offers)));
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
            $offer->callbackdata = '@my_offer_update';
            $offer->msgId = $this->messageId;
            PageGenerator::generate($this->telegram, EditOfferData::generate($this->telegramId, $offer), InlineButtonsForEditOffers::prepare($offer));
        }
    }

    private function prepareOffersData($offers)
    {
        foreach ($offers as $offer)
        {
            $offer->city = $this->region->getCityById($offer->city_id)->city;
            $offer->category = $this->category->getCategoryById($offer->category_id)->category;
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
            PageGenerator::generate($this->telegram, CategoriesData::generate($this->telegramId, $this->messageId, 'select_my_offer_category'), 'profile_region', );

        }

    }
}