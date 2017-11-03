<?php

require __DIR__."/../../autoload.php";
require __DIR__."/../../config/telegram.php";

use Telegram\Bot\Bot;

if (isset($argv[1])) {
    $app = new Bot(urldecode($argv[1]));
    $app->run();
}
