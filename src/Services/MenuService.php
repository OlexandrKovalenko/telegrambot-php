<?php

namespace App\Messages\Menu;


use App\Botlogger\BotLogger;
use App\TelegramSession\TelegramSessionService;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class MenuService
{
    private Api $telegram;
    private $data;

    function __construct($telegram, $data)
    {
        $this->telegram = $telegram;
        $this->data = $data;
    }

    public function showButtons($param = null)
    {
        $this->data['botMessage'] ? $this->generateButtonMenu($this->data['userSite'], $this->data['botMessage']) : null;
        $this->data['inlineMsg'] ? $this->generateInlineMenu($this->data['userSite'], $this->data['inlineMsg'], $param) : null;
        TelegramSessionService::setSession($this->data['id'], $this->data['userSite']);
    }

    private function generateButtonMenu($userSite, $botMessage)
    {
        $reply_markup = Keyboard::make([
            'keyboard' => $this->createKeyboards($userSite),
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
        $response = $this->telegram->setAsyncRequest(true)->sendMessage([
            'chat_id' => $this->data['id'],
            'parse_mode' => 'MarkdownV2',
            'text' => $botMessage,
            'reply_markup' => $reply_markup
        ]);

        //$messageId = $response->getMessageId();
    }

    private function generateInlineMenu($userSite, $botMessage, $param)
    {

        $reply_markup = json_encode($this->createInlineKeyboards($userSite, $param), true);
        $this->telegram->setAsyncRequest(true)->sendMessage([
            'chat_id' => $this->data['id'],
            'parse_mode' => 'MarkdownV2',
            'text' => $botMessage,
            'reply_markup' => $reply_markup
        ]);
    }

    private function createKeyboards($userSite)
    {
        return CreateButtonKeyboard::create($userSite);
    }

    private function createInlineKeyboards($userSite, $callback)
    {
        return CreateInLineKeyboard::create($userSite, $callback);
    }

}