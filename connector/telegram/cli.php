<?php

require __DIR__."/../../autoload.php";
require __DIR__."/../../config/telegram.php";

if (isset($argv[1])) {
    $app = new \Telegram\Bot\Bot(urldecode($argv[1]));
    $app->run();
}
