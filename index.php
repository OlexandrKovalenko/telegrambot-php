<?php

namespace App;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/env.php';
require __DIR__ . '/src/Database/DBConnect.php';
require __DIR__ . '/src/Database/User.php';
require __DIR__ . '/src/Actions/BotLogger.php';
require __DIR__ . '/src/Services/MenuService.php';
require __DIR__ . '/src/Services/TextMessageService.php';
require __DIR__ . '/src/Actions/Keyboard/CreateButtonKeyboard.php';
require __DIR__ . '/src/Actions/Keyboard/CreateInLineKeyboard.php';


use App\Botlogger\BotLogger;
use App\Messages\TextMessageService;
use Telegram\Bot\Api;

$key = env::TELEGRAMKEY;
$telegram =  new Api($key, true);

function BotApp(Api $telegram)
{
    if(isset($telegram->getWebhookUpdate()['message']['text']) && !$telegram->getWebhookUpdate()['message']['from']['is_bot']) {
        $textMessage = new TextMessageService($telegram, $telegram->getWebhookUpdate()['message']);
        $textMessage->handler();
    }
    elseif (isset($telegram->getWebhookUpdate()['callback_query']) && $telegram->getWebhookUpdate()['callback_query']['message']['from']['id'] == 5216479381) {
        $telegram->sendMessage(['chat_id' => $telegram->getWebhookUpdate()['callback_query']['from']['id'], 'parse_mode' => 'HTML', 'text' => "This is - <b>CALLBACK!!!</b>"]);

        //$callbackMessage = new CallbackHandlerService(Telegram::getWebhookUpdates()['callback_query']);
        //$callbackMessage->handler();
    }
    else {
        $telegram->sendMessage(['chat_id' => $telegram->getWebhookUpdate()['message']['from']['id'], 'parse_mode' => 'HTML', 'text' => "This is - <b>XZ</b>"]);
    }
}

BotApp($telegram);

//$testData = require_once __DIR__ . '/UnitTest/data.php';
