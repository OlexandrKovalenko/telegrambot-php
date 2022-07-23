<?php

namespace App\Services;


use App\Actions\BotLogger;
use App\Actions\CallbackActionCase\CaseEditMyOffer;
use App\Actions\CallbackActionCase\CaseMyOffers;
use App\Actions\GetPhoto;
use App\Actions\Keyboard\InlineButtonConfirm;
use App\Actions\Keyboard\InlineButtonsForMyProfile;
use App\Actions\Page\MainData;
use App\Actions\Page\ProfileData;
use App\Actions\Page\StartData;
use App\Actions\TextMessageActionCase\TextMessageCaseUpdateMyOfferData;
use App\Database\Region;
use App\Database\User;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
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

    /**
     * @throws TelegramSDKException
     */
    function handler()
    {
        switch ($this->text)
        {
            case '/start':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                PageGenerator::generate($this->telegram, StartData::generate($this->telegramId));
                break;
            case 'Головне меню':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId]);
                PageGenerator::generate($this->telegram, MainData::generate($this->telegramId));
                break;
            case 'Мій профіль':
                $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                PageGenerator::generate($this->telegram, ProfileData::generate($this->telegramId), InlineButtonsForMyProfile::prepare());
                break;
            case '/photo':
                BotLogger::store(__DIR__ . '/storage/img/22S7MTRO8RMW.jpg');
                $file = InputFile::create('https://akm-img-a-in.tosshub.com/indiatoday/images/story/201311/googlelogo_660_n_050313110041_112013012607.jpg', 'googlelogo_660_n_050313110041_112013012607.jpg');
                $response = $this->telegram->sendPhoto([
                    'chat_id' => $this->telegramId,
                    'photo' => $file,
                    'caption' => __DIR__ . 'storage/img/22S7MTRO8RMW.jpg',
                    'parse_mode' => "html"
                ]);
                BotLogger::store($response);

                break;
        }

        if (TelegramSessionService::getSession($this->telegramId)->last_activity)
        {
            $userSite = TelegramSessionService::getSession($this->telegramId)->last_activity;
            $data = explode("#", $userSite);
            switch ($userSite)
            {
                case 'main_menu/':
                    PageGenerator::generate($this->telegram, MainData::generate($this->telegramId));
                    break;
                case 'my_offers':
                    $this->telegram->sendMessage(['chat_id' => $this->telegramId, 'parse_mode' => 'HTML', 'text' => $this->text]);
                    $this->telegram->answerCallbackQuery([
                        'callback_query_id' => $this->telegram->getWebhookUpdate()['callback_query']['id'],
                        'text'=>'Запити',
                        'show_alert'=> false,
                        'cache_time'=>1
                    ]);
                    break;
                case 'update_name':
                case 'update_lastName':
                    $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                    $validate = new ValidationService();
                    $validate->max_length = 13;
                    if ($validate->validateText($this->text))
                        {
                            $errors = implode("\n\r", $validate->validateText($this->text));
                            PageGenerator::generate($this->telegram, ['id'=>$this->telegramId,'userSite'=>'confim_data', 'inlineMsg'=>"$errors\n\rВвести знову?"], InlineButtonConfirm::prepare('@'.$userSite));
                        }
                        else
                        {
                            if ($userSite === 'update_name') $this->getUser = $this->user->update($this->telegramId, ['first_name'=> $this->text]);
                            if ($userSite === 'update_lastName') $this->getUser = $this->user->update($this->telegramId, ['last_name'=> $this->text]);
                            PageGenerator::generate($this->telegram, ProfileData::generate($this->telegramId), InlineButtonsForMyProfile::prepare());
                        }
                break;
                case 'update_phone':
                    $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                    $validate = new ValidationService();

                    if ($this->telegram->getWebhookUpdate()['message']['contact']['phone_number'] && $validate->validatePhone($this->telegram->getWebhookUpdate()['message']['contact']['phone_number'])
                    || $this->telegram->getWebhookUpdate()['message']['text'] && $validate->validatePhone($this->telegram->getWebhookUpdate()['message']['text']))
                    {
                        $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                        $this->getUser = $this->user->update($this->telegramId, ['phone'=>
                            $this->telegram->getWebhookUpdate()['message']['contact']['phone_number'] ?? $validate->phoneNumFixer($this->telegram->getWebhookUpdate()['message']['text'])
                        ]);
                        PageGenerator::generate($this->telegram, ProfileData::generate($this->telegramId), InlineButtonsForMyProfile::prepare());
                        TelegramSessionService::setSession($this->telegramId, 'my_profile');
                    }
                    else
                    {
                        $error_phonenumber = "<b>Невірний номер</b>\n\r<i>- Будь ласка, введіть номер телефону українського мобільного оператора.</i> ";
                        PageGenerator::generate($this->telegram, ['id'=>$this->telegramId,'userSite'=>'confim_data', 'inlineMsg'=>"$error_phonenumber\n\rВвести знову?"], InlineButtonConfirm::prepare('@'.$userSite));
                    }
                    break;
                case (preg_match('/my_offer_store#.*/', $userSite) ? $userSite : null):

                    if ($data[1] ==='img')
                    {

                        $this->telegram->deleteMessage(['chat_id' => $this->telegramId, 'message_id' => $this->messageId-1]);
                        if ($this->message->photo)
                        {                        BotLogger::store($this->message->photo[count($this->message->photo)-1]);

                            $fileId = $this->message->photo[count($this->message->photo)-1]->file_id;

                            GetPhoto::get($fileId, $data[2]);
                            CaseEditMyOffer::edit($this->telegram, $this->telegramId, $data[2]);
                        }
                        else
                        {
                            PageGenerator::generate($this->telegram, ['id'=>$this->telegramId,'userSite'=>'confim_data', 'inlineMsg'=>"Завантажте фото.\n\rПовторити?"], InlineButtonConfirm::prepare("@$userSite#"));

                        }
                    }
                    else
                    {
                        $validate = new ValidationService();
                        $validate->min_length = 10;
                        if ($validate->validateText($this->text))
                        {
                            $errors = implode("\n\r", $validate->validateText($this->text));
                            PageGenerator::generate($this->telegram, ['id'=>$this->telegramId,'userSite'=>'confim_data', 'inlineMsg'=>"$errors\n\rВвести знову?"], InlineButtonConfirm::prepare("@$userSite#"));
                        }
                        else
                        {
                            $data['row'] = $data[1];
                            if (TextMessageCaseUpdateMyOfferData::update($data, $this->text))
                                CaseEditMyOffer::edit($this->telegram, $this->telegramId, $data[2]);
                        }

                    }
                    break;
            }
        }
    }
}