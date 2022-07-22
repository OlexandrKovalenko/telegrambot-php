<?php

namespace App;
error_reporting(0);
require __DIR__ . '/vendor/autoload.php';
/*require __DIR__ . '/env.php';
require __DIR__ . '/app/Database/DBConnect.php';
require __DIR__ . '/app/Database/User.php';
require __DIR__ . '/app/Database/TelegramSession.php';
require __DIR__ . '/app/Database/Region.php';
require __DIR__ . '/app/Database/Category.php';
require __DIR__ . '/app/Database/Offer.php';
require __DIR__ . '/app/Actions/BotLogger.php';
require __DIR__ . '/app/Actions/Translit.php';
require __DIR__ . '/app/Services/PageGenerator.php';
require __DIR__ . '/app/Actions/Page/MainData.php';
require __DIR__ . '/app/Actions/Page/StartData.php';
require __DIR__ . '/app/Actions/Page/ProfileData.php';
require __DIR__ . '/app/Actions/Page/RegionData.php';
require __DIR__ . '/app/Actions/Page/MyOffersData.php';
require __DIR__ . '/app/Actions/Page/EditOfferData.php';
require __DIR__ . '/app/Actions/Page/CategoriesData.php';
require __DIR__ . '/app/Services/InlineMenuService.php';
require __DIR__ . '/app/Services/UserService.php';
require __DIR__ . '/app/Services/TelegramSessionService.php';
require __DIR__ . '/app/Services/MenuService.php';
require __DIR__ . '/app/Services/TextMessageService.php';
require __DIR__ . '/app/Services/CallbackService.php';
require __DIR__ . '/app/Services/OfferService.php';
require __DIR__ . '/app/Actions/Keyboard/CreateButtonKeyboard.php';
require __DIR__ . '/app/Actions/Keyboard/CreateInLineKeyboard.php';
require __DIR__ . '/app/Actions/Keyboard/CreateRegionInlineKeyboard.php';
require __DIR__ . '/app/Actions/Keyboard/CreateOfferInlineKeyboard.php';
require __DIR__ . '/app/Actions/Keyboard/CreateEditMyOfferInlineKeyboard.php';
require __DIR__ . '/app/Actions/Keyboard/InlineButtonsForMyProfile.php';
require __DIR__ . '/app/Actions/Keyboard/InlineButtonsForMyOffersList.php';
require __DIR__ . '/app/Services/ValidationService.php';*/

//require __DIR__ . '/app/Actions/Keyboard/InlineButtonsRegionSelector.php';

use App\Actions\BotLogger;

use App\Services\CallbackService;
use App\Services\TextMessageService;
use App\Services\UserService;
use Telegram\Bot\Api;

$key = env::TELEGRAMKEY;
$telegram =  new Api($key, true);

function BotApp(Api $telegram)
{
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
