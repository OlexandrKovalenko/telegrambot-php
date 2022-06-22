<?php

namespace App\Messages;


use App\Botlogger\BotLogger;
use App\Database\User;
use App\Messages\Menu\MenuService;
use App\TelegramSession\TelegramSessionService;
use App\User\UserService;
use Telegram\Bot\Api;

class TextMessageService
{
    private $telegramId, $text, $messageId;
    private Api $telegram;
    private TelegramSessionService $session;
    private $user;

    function __construct($telegram, $textMessage)
    {
        $this->telegramId = $textMessage['from']['id'];
        $this->text = $textMessage['text'];
        $this->messageId = $textMessage['message_id'];
        $this->telegram = $telegram;
        $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
        $this->session = new TelegramSessionService();
        $obj = new User();
        $this->user = $obj->findByTelegramId($textMessage['from']['id']);
    }

    function handler()
    {
        $showMenu = new MenuService($this->telegram, $this->telegramId);

        switch ($this->text)
        {
            case '/start':
                $userSite = 'start';
                $botMessage = "This is \- *START*";
                $showMenu->showButtonsMenu($userSite, $botMessage );
                $this->session->setSession($this->telegramId, $userSite);
                break;
            case 'Главное меню':
                $userSite = 'main_menu';
                $botMessage = "This is \- *Главное меню*";
                $showMenu->showButtonsMenu($userSite, $botMessage );
                $this->session->setSession($this->telegramId, $userSite);
                break;
            case 'Мой профиль':
                $userSite = 'my_profile';

                $inLineMsg = "*Информация о пользователе:*\n\r*Имя:* {$this->user?->first_name}\n\r*Фамилия\:* {$this->user?->last_name}\n\r*Username:* @{$this->user?->username}\n\r*Telegram ID:* {$this->user?->telegram_id}";
                $showMenu->showInlineMenu('my_profile', $inLineMsg);

                $botMessage = "This is \- *Мой профиль*\n\rДля возврата на главную воспользуйтесь кнопками ниже:";
                $showMenu->showButtonsMenu('my_profile', $botMessage );
                $this->session->setSession($this->telegramId, $userSite);
                break;
            default:
                $this->telegram->sendMessage(['chat_id' => $this->telegramId,'reply_to_message_id' => $this->messageId,'text' => 'wtf?',]);
        }
    }
}