<?php

namespace App\Messages;


use App\Botlogger\BotLogger;
use App\Messages\Menu\MenuService;
use Telegram\Bot\Api;

class TextMessageService
{
    private $telegramId, $text, $messageId, $user;
    private Api $telegram;

    function __construct($telegram, $textMessage){
        $this->telegramId = $textMessage['from']['id'];
        $this->text = $textMessage['text'];
        $this->messageId = $textMessage['message_id'];
        $this->telegram = $telegram;
        $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
    }

    function handler()
    {
        $showMenu = new MenuService($this->telegram, $this->telegramId);

        switch ($this->text) {
            case 'Главное меню':
                $botMessage = "This is \- *Главное меню*";
                $showMenu->showButtonsMenu('main_menu', $botMessage );
                break;
            case 'Мой профиль':
                $inLineMsg = "*Информация о пользователе:*\n\r";
                $showMenu->showInlineMenu('my_profile', $inLineMsg);

                $botMessage = "This is \- *Мой профиль*\n\rДля возврата на главную воспользуйтесь кнопками ниже:";
                $showMenu->showButtonsMenu('my_profile', $botMessage );

/*                $inLineMsg = "*Информация о пользователе:*\n\r*Имя:* ".$this->user->firstname."\n\r*Фамилия:* ".$this->user->lastname."\n\r*Username:* @".$this->user->username."\n\r*Telegram ID:* ".$this->user->telegram_id;
                $showMenu->showInlineMenu('my_profile', $inLineMsg);
                $btnMessage = "Для возврата на главную воспользуйтесь кнопками ниже:";
                $showMenu->showButtonsMenu('my_profile', $btnMessage,);
                TelegramSessionHandlerService::setSession($this->user->id, 'my_profile')->last_activity;*/
                break;
        }
    }
}