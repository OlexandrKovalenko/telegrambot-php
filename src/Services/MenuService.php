<?php

namespace App\Messages\Menu;


use App\Botlogger\BotLogger;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class MenuService
{
    private $telegramId;
    private Api $telegram;

    function __construct($telegram, $id) {
        $this->telegramId = $id;
        $this->telegram = $telegram;
    }

    function showButtonsMenu($userSite, $botMessage){
        $reply_markup = Keyboard::make([
            'keyboard' => $this->createKeyboards($userSite),
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
        $response = $this->telegram->setAsyncRequest(true)->sendMessage([
            'chat_id' => $this->telegramId,
            'parse_mode' => 'MarkdownV2',
            'text' => $botMessage,
            'reply_markup' => $reply_markup
        ]);

        //$messageId = $response->getMessageId();
    }

    function showInlineMenu($userSite, $botMessage){
        $reply_markup = json_encode($this->createInlineKeyboards($userSite), true);
        $response = $this->telegram->setAsyncRequest(true)->sendMessage([
            'chat_id' => $this->telegramId,
            'parse_mode' => 'MarkdownV2',
            'text' => $botMessage,
            'reply_markup' => $reply_markup
        ]);
    }

    static function createKeyboards($userSite) {
        return CreateButtonKeyboard::create($userSite);
    }

    public function createInlineKeyboards($userSite){
        return CreateInLineKeyboard::create($userSite);
    }
}