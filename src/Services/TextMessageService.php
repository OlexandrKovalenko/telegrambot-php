<?php

namespace App\Messages;


use App\Botlogger\BotLogger;
use App\Database\Region;
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
        $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
        $this->user = new User();
        $this->getUser = $this->user->findByTelegramId($this->telegramId);
        $this->region = new Region();
        $this->getRegion = $this->region->getUserRegion($this->getUser->id);
    }

    function handler()
    {
        switch ($this->text)
        {
            case '/start':
                PageGenerator::showStart($this->telegram, StartData::generate($this->telegramId));
                break;
            case 'Главное меню':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                PageGenerator::showMain($this->telegram, MainData::generate($this->telegramId));
                break;
            case 'Мой профиль':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->getUser, $this->getRegion));
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
                    $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                    if (ValidationService::validateName($this->text))
                        {
                            $errors = implode("\n\r", ValidationService::validateName($this->text));
                            //$this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => $errors]);
                            PageGenerator::showConfirm($this->telegram, ['id'=>$this->telegramId,'userSite'=>'confim_data', 'inlineMsg'=>"$errors\n\rПовторить ввод?"], '@'.$userSite);
                        }
                        else
                        {
                            if ($userSite === 'update_name') $this->getUser = $this->user->update($this->telegramId, ['first_name'=> $this->text]);
                            if ($userSite === 'update_lastName') $this->getUser = $this->user->update($this->telegramId, ['last_name'=> $this->text]);
                            PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->getUser, $this->getRegion));
                        }
                break;
                case 'update_phone':
                    $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);

                    if ($this->telegram->getWebhookUpdate()['message']['contact']['phone_number'] && ValidationService::validatePhone($this->telegram->getWebhookUpdate()['message']['contact']['phone_number'])
                    || $this->telegram->getWebhookUpdate()['message']['text'] && ValidationService::validatePhone($this->telegram->getWebhookUpdate()['message']['text']))
                    {
                        $this->getUser = $this->user->update($this->telegramId, ['phone'=>
                            $this->telegram->getWebhookUpdate()['message']['contact']['phone_number'] ?? ValidationService::phoneNumFixer($this->telegram->getWebhookUpdate()['message']['text'])
                        ]);
                        PageGenerator::showProfile($this->telegram, ProfileData::generate($this->telegramId, $this->getUser, $this->getRegion));
                        TelegramSessionService::setSession($this->telegramId, 'my_profile');
                    }
                    else
                    {
                        $error_phonenumber = "<b>Не корректный номер.</b>\n\r<i>- Принимаются только номера Украинских мобильных операторов.</i> ";
                        //$this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => $error_phonenumber]);
                        PageGenerator::showConfirm($this->telegram, ['id'=>$this->telegramId,'userSite'=>'confim_data', 'inlineMsg'=>"$error_phonenumber\n\rПовторить ввод?"], '@'.$userSite);
                    }
                    break;
            }
        }
    }
}