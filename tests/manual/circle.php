<?php

require __DIR__."/../../autoload.php";

use Telegram as B;

B::sendMessage(
    [
        "text"		 => "CircleCI report : \n<b>Success! Your tests passed on CircleCI!</b>",
        "chat_id"	 => -1001128531173,
        "parse_mode" => "HTML"
    ]
);
