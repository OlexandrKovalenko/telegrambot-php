<?php

namespace App\Services;


use App\Actions\BotLogger;
use App\Actions\Keyboard\CreateButtonKeyboard;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;

class MenuService
{
    private Api $telegram;
    private $data;
    /**
     * @var mixed|null
     */
    private mixed $menuArr;

    function __construct($telegram, $data, $menuArr = null)
    {
        $this->telegram = $telegram;
        $this->data = $data;
        $this->menuArr = $menuArr;
    }

    public function showButtons()
    {
        $this->data['photo'] != null ? $this->sendOfferWithPhoto($this->menuArr,$this->data['inlineMsg']) : null;
        $this->data['msgId'] && $this->data['inlineMsg'] && ! $this->data['photo'] ?  $this->generateAnswerInlineMenu($this->menuArr,$this->data['inlineMsg']) : null;
        $this->data['botMessage'] && !$this->data['msgId'] ? $this->generateButtonMenu($this->data['userSite'], $this->data['botMessage']) : null;
        $this->data['inlineMsg'] && !$this->data['msgId'] && ! $this->data['photo']  ? $this->generateInlineMenu($this->menuArr, $this->data['inlineMsg']) : null;
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

    private function generateAnswerButtonMenu($userSite, $botMessage)
    {
        $reply_markup = Keyboard::make([
            'keyboard' => $this->createKeyboards($userSite),
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
        $response = $this->telegram->setAsyncRequest(true)->editMessageText([
            'chat_id' => $this->data['id'],
            'message_id' => $this->data['msgId'],
            'parse_mode' => 'MarkdownV2',
            'text' => $botMessage,
            'reply_markup' => $reply_markup
        ]);
    }

    private function generateInlineMenu($arr, $botMessage)
    {
        $reply_markup = json_encode($this->createInlineKeyboards($arr), true);
        $this->telegram->setAsyncRequest(true)->sendMessage([
            'chat_id' => $this->data['id'],
            'parse_mode' => 'HTML',
            'text' => $botMessage,
            'reply_markup' => $reply_markup
        ]);
    }

    private function generateAnswerInlineMenu($arr, $botMessage)
    {
        $reply_markup = json_encode($this->createInlineKeyboards($arr), true);
        $this->telegram->setAsyncRequest(true)->editMessageText([
            'chat_id' => $this->data['id'],
            'message_id' => $this->data['msgId'],
            'parse_mode' => 'HTML',
            'text' => $botMessage,
            'reply_markup' => $reply_markup,
        ]);
    }

    private function sendOfferWithPhoto($arr, $botMessage)
    {
        $file = InputFile::create('storage/img/'.$this->data['photo'], $this->data['photo']);

        $reply_markup = json_encode($this->createInlineKeyboards($arr), true);
        $this->telegram->setAsyncRequest(true)->sendPhoto([
            'chat_id' => $this->data['id'],
            'photo' => $file,
            'caption' => $botMessage,
            'reply_markup' => $reply_markup,
            'parse_mode' => 'HTML',
        ]);
    }

    private function createKeyboards($userSite)
    {
        return CreateButtonKeyboard::create($userSite);
    }

    private function createInlineKeyboards($arr)
    {
        $keyboard = new InlineMenuService($arr);
        return $keyboard->create();
    }

}