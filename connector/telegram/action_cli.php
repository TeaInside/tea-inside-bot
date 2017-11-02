<?php

require __DIR__."/../../config/telegram.php";
require __DIR__."/../../autoload.php";

print Telegram::{$argv[1]}(urldecode(json_decode($argv[2])))['content'];