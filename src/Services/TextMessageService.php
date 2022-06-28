<?php

namespace App\Messages;


use App\Botlogger\BotLogger;
use App\Database\User;
use App\Messages\Menu\MenuService;
use App\Messages\Menu\ValidationService;
use App\Page\MainData;
use App\Page\PageGenerator;
use App\Page\ProfileData;
use App\Page\StartData;
use App\TelegramSession\TelegramSessionService;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;

class TextMessageService
{
    private $telegramId, $text, $messageId;
    private $user;
    private EditedMessage|Collection|Message $message;
    private Api $telegram;

    function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
        $this->message = $this->telegram->getWebhookUpdate()->getMessage();
        $this->telegramId = $this->message->getFrom()->getId();
        $this->text = $this->message->getText();
        $this->messageId = $this->message->getMessageId();
        //$this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
        $obj = new User();
        $this->user = $obj->findByTelegramId($this->telegramId);
    }

    function handler()
    {
        switch ($this->text)
        {
            case '/start':
                PageGenerator::showStart($this->telegram, StartData::generate($this->telegramId));
                break;
            case 'Главное меню':
                PageGenerator::showMain($this->telegram, MainData::generate($this->telegramId));
                break;
            case 'Мой профиль':
                PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->user));
                break;
        }

        if (TelegramSessionService::getSession($this->telegramId)->last_activity)
        {
            $userSite = TelegramSessionService::getSession($this->telegramId)->last_activity;
            switch ($userSite)
            {
                case 'main_menu/':
                    PageGenerator::showMain($this->telegram, MainData::generate($this->telegramId));
                    break;
                case 'my_offers':
                    $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => $this->text]);
                    $this->telegram->answerCallbackQuery([
                        'callback_query_id' => $this->telegram->getWebhookUpdate()['callback_query']['id'],
                        'text'=>'Заявки',
                        'show_alert'=> false,
                        'cache_time'=>1
                    ]);
                    break;
                case 'update_name':
                case 'update_lastName':
                    if (ValidationService::validateName($this->text))
                        {
                            $errors = implode("\n\r", ValidationService::validateName($this->text));
                            $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => $errors]);
                            PageGenerator::showConfirm($this->telegram, ['id'=>$this->telegramId,'userSite'=>'confim_data', 'inlineMsg'=>'Повторить ввод?'], '@'.$userSite);
                        }
                        else
                        {
                            $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => $this->text.' Имя сохранено.']);
                            PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->user));
                        }
                break;
                case 'update_phone':
                    if ($this->telegram->getWebhookUpdate()['message']['contact']['phone_number'] && ValidationService::validatePhone($this->telegram->getWebhookUpdate()['message']['contact']['phone_number'])
                    || $this->telegram->getWebhookUpdate()['message']['text'] && ValidationService::validatePhone($this->telegram->getWebhookUpdate()['message']['text']))
                    {
                        PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->user));
                        TelegramSessionService::setSession($this->telegramId, 'my_profile');
                    }
                    else
                    {
                        $error_phonenumber = "<b>Не корректный номер.</b>\n\r<i>- Принимаются только номера Украинских мобильных операторов.</i> ";
                        $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => $error_phonenumber]);
                        PageGenerator::showConfirm($this->telegram, ['id'=>$this->telegramId,'userSite'=>'confim_data', 'inlineMsg'=>'Повторить ввод?'], '@'.$userSite);
                    }
                    break;
            }
        }
    }
}