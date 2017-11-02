<?php

require __DIR__."/../../config/telegram.php";
require __DIR__."/../../autoload.php";

print Telegram::{$argv[1]}(json_decode(urldecode($argv[2]), true))['content'];