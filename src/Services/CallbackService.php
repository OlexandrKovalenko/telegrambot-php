<?php


namespace App\Messages;


use App\Botlogger\BotLogger;
use App\Database\Region;
use App\Database\User;
use App\Page\MainData;
use App\Page\PageGenerator;
use App\Page\ProfileData;
use App\Page\RegionData;
use App\TelegramSession\TelegramSessionService;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Button;
use Telegram\Bot\Keyboard\Keyboard;

class CallbackService
{
    private $telegramId, $messageId, $сallback_data, $user;
    private Api $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
        $this->сallback_data = $this->telegram->getWebhookUpdate()['callback_query']['data'];
        $this->telegramId = $this->telegram->getWebhookUpdate()['callback_query']['from']['id'];
        $this->messageId = $this->telegram->getWebhookUpdate()->getMessage()->getMessageId();
        $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
        $obj = new User();
        $this->user = $obj->findByTelegramId($this->telegramId);
        $obj = new Region();
        $this->region = $obj->getUserRegion($this->user->id);
    }

    function handler()
    {
        if (TelegramSessionService::getSession($this->telegramId)->last_activity === 'main_menu' )
        {
            $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => '<i>Время Вашей сессии уже истекло. Возвращаемся на главную.</i>']);
            PageGenerator::showMain($this->telegram, MainData::generate($this->telegramId));
        }

        //count(explode("#", $this->сallback_data)) == 2 ? $data = explode("#", $this->сallback_data)[0]: $data = $this->сallback_data;

        switch ($this->сallback_data){
            case '@update_name_repeat':
            case '@update_name':
            TelegramSessionService::setSession($this->telegramId, 'update_name');
            $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => 'Введите свое имя:']);
                break;
            case '@update_lastName_repeat':
            case '@update_lastName':
                TelegramSessionService::setSession($this->telegramId, 'update_lastName');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => 'Введите свою фамилию:']);
                break;

            case '@update_phone_repeat':
            case '@update_phone':
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
                PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->user, $this->region));
            break;
            case '@update_region':
                TelegramSessionService::setSession($this->telegramId, 'select_my_region');
                PageGenerator::showRegion($this->telegram, RegionData::generate($this->telegramId));
                break;
            case (preg_match('/@my_region_#.*/', $this->сallback_data) ? $this->сallback_data : null):
                TelegramSessionService::setSession($this->telegramId, 'select_my_city');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => '*Ваш выбор области:* '.explode("#", $this->сallback_data)[1]]);
                PageGenerator::showRegion($this->telegram, RegionData::generate($this->telegramId, 'select_my_city'), explode("#", $this->сallback_data)[1] );
                break;
            case (preg_match('/@my_region_city_#.*/', $this->сallback_data) ? $this->сallback_data : null):
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => '*Ваш выбор:* '.explode("#", $this->сallback_data)[1]]);
                PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->user, $this->region));
                break;
            case '@my_offers':
                TelegramSessionService::setSession($this->telegramId, 'update_address');
                $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => '*Ваши заявки:*']);
                break;
            case '@main_menu':
                TelegramSessionService::setSession($this->telegramId, 'main_menu');
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
}