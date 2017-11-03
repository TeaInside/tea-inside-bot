<?php

require __DIR__."/../../autoload.php";
require __DIR__."/../../config/line.php";

if (isset($argv[1])) {
    $app = new \LINE\Bot\Bot(urldecode($argv[1]));
    $app->run();
}