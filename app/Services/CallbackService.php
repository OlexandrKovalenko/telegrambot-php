<?php


namespace App\Services;


use App\Actions\BotLogger;
use App\Actions\CallbackActionCase\CaseCategorySelect;
use App\Actions\CallbackActionCase\CaseCategoryShow;
use App\Actions\CallbackActionCase\CaseCitySelect;
use App\Actions\CallbackActionCase\CaseCityShow;
use App\Actions\CallbackActionCase\CaseEditMyOffer;
use App\Actions\CallbackActionCase\CaseMyOffers;
use App\Actions\CallbackActionCase\CaseRegionShow;
use App\Actions\CallbackActionCase\CaseUpdateMyOffer;
use App\Actions\Keyboard\InlineButtonsForMyProfile;
use App\Actions\Page\MainData;
use App\Actions\Page\ProfileData;
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
        if (TelegramSessionService::getSession($this->telegramId)->last_activity === 'main_menu' )
        {
            $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
            $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => '<i>Час сесії вичерпано. Повернення до головного меню.</i>']);
            PageGenerator::generate($this->telegram, MainData::generate($this->telegramId));
        }
        $data = explode("#", $this->сallback_data);

        switch ($this->сallback_data){
            case '@update_phone_cancel':
            case '@update_lastName_cancel':
            case '@update_name_cancel':
            case '@my_profile':
                PageGenerator::generate($this->telegram, ProfileData::generate($this->telegramId, $this->messageId), InlineButtonsForMyProfile::prepare());
                break;
            case '@update_name_accept':
            case '@update_name':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                TelegramSessionService::setSession($this->telegramId, 'update_name');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => 'Введіть ім\'я:']);
                break;
            case '@update_lastName_accept':
            case '@update_lastName':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                TelegramSessionService::setSession($this->telegramId, 'update_lastName');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => 'Введіть прізвище:']);
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
                    'text' => 'Введіть свій номер телефону:',
                    'request_contact' => true,
                    'reply_markup' => $reply_markup]);
                break;
            case '@update_region':
                $data = explode("#", $this->сallback_data);
                CaseRegionShow::show($this->telegram, $this->telegramId, $this->messageId, $data);
                break;
            case '@update_category':
                $data = explode("#", $this->сallback_data);
                CaseCategoryShow::show($this->telegram, $this->telegramId, $this->messageId, $data);
                break;
            case (preg_match('/@region#.*/', $this->сallback_data) ? $this->сallback_data : null):
                $data = explode("#", $this->сallback_data);
                CaseCityShow::show($this->telegram, $this->telegramId, $this->messageId, $data);
                break;
            case (preg_match('/@region_city#.*/', $this->сallback_data) ? $this->сallback_data : null):
                $data = explode("#", $this->сallback_data);
                CaseCitySelect::select($this->telegram, $this->telegramId, $this->messageId, $data);
                break;
            case '@create_new_offer':
                $newOffer = OfferService::create($this->getUser->id, $this->getRegion->located_city_id);
                CaseEditMyOffer::edit($this->telegram, $this->telegramId, $this->offer->getOfferById($newOffer)->callback, $this->messageId);
            case '@my_offers':
                CaseMyOffers::show($this->telegram, $this->telegramId, $this->messageId);
                break;
            case '@my_offers_with_img':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                CaseMyOffers::show($this->telegram, $this->telegramId);
                break;
            case (preg_match('/@my_offer_store#.*#_cancel/', $this->сallback_data) ? $this->сallback_data : null):
                $data[1] = $data[2];
            case (preg_match('/@my_offer_edit#.*/', $this->сallback_data) ? $this->сallback_data : null):
                CaseEditMyOffer::edit($this->telegram, $this->telegramId, $data[1], $this->messageId);
                break;
            case (preg_match('/@my_offer_store#.*#_accept/', $this->сallback_data) ? $this->сallback_data : null):
            case (preg_match('/@my_offer_update#.*/', $this->сallback_data) ? $this->сallback_data : null):
                CaseUpdateMyOffer::update($this->telegram, $this->telegramId, $this->messageId, $data);
                break;
            case (preg_match('/@category#.*/', $this->сallback_data) ? $this->сallback_data : null):
                CaseCategorySelect::select($this->telegram, $this->telegramId, $this->messageId, $data);
                break;
            case '@main_menu':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                $this->telegram->answerCallbackQuery([
                    'callback_query_id' => $this->telegram->getWebhookUpdate()['callback_query']['id'],
                    'text'=>'На головну...',
                    'show_alert'=> false,
                    'cache_time'=>1
                ]);
                PageGenerator::generate($this->telegram, MainData::generate($this->telegramId));
                break;
            default:
        }
    }
}