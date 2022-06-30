<?php

namespace App;
error_reporting(0);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/env.php';
require __DIR__ . '/src/Database/DBConnect.php';
require __DIR__ . '/src/Database/User.php';
require __DIR__ . '/src/Database/TelegramSession.php';
require __DIR__ . '/src/Database/Region.php';
require __DIR__ . '/src/Actions/BotLogger.php';
require __DIR__ . '/src/Actions/Translit.php';
require __DIR__ . '/src/Services/UserService.php';
require __DIR__ . '/src/Services/TelegramSessionService.php';
require __DIR__ . '/src/Services/MenuService.php';
require __DIR__ . '/src/Services/TextMessageService.php';
require __DIR__ . '/src/Services/CallbackService.php';
require __DIR__ . '/src/Actions/Keyboard/CreateButtonKeyboard.php';
require __DIR__ . '/src/Actions/Keyboard/CreateInLineKeyboard.php';
require __DIR__ . '/src/Actions/Keyboard/CreateRegionInlineKeyboard.php';
require __DIR__ . '/src/Services/PageGenerator.php';
require __DIR__ . '/src/Actions/Page/MainData.php';
require __DIR__ . '/src/Actions/Page/StartData.php';
require __DIR__ . '/src/Actions/Page/ProfileData.php';
require __DIR__ . '/src/Actions/Page/RegionData.php';
require __DIR__ . '/src/Services/ValidationService.php';


use App\Botlogger\BotLogger;
use App\Database\Region;
use App\Messages\CallbackService;
use App\Messages\Menu\CreateRegionInlineKeyboard;
use App\Messages\TextMessageService;
use App\User\UserService;
use Telegram\Bot\Api;

$key = env::TELEGRAMKEY;
$telegram =  new Api($key, true);

function BotApp(Api $telegram)
{
    //BotLogger::store($telegram->getWebhookUpdate());

    if($telegram->getWebhookUpdate()->detectType() === 'message' && !$telegram->getWebhookUpdate()->getMessage()->getFrom()['is_bot'])
    {
        UserService::checkUser($telegram->getWebhookUpdate()->getMessage()->getFrom());
        $textMessage = new TextMessageService($telegram);
        $textMessage->handler();
    }
    elseif ($telegram->getWebhookUpdate()->detectType() === 'callback_query' && $telegram->getWebhookUpdate()->getMessage()->getFrom()->getId() == 5216479381)
    {
        $callbackMessage = new CallbackService($telegram);
        $callbackMessage->handler();
    }
    else
    {
        $telegram->sendMessage(['chat_id' => $telegram->getWebhookUpdate()['message']['from']['id'], 'parse_mode' => 'HTML', 'text' => "This is - <b>XZ</b>"]);
    }
}

BotApp($telegram);