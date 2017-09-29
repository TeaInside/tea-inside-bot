<?php

require __DIR__."/../../autoload.php";

use Telegram as B;

B::sendMessage(
	[
		"text"		=> "Hello World!",
		"chat_id"	=> -1001128531173,
		"reply_to_message_id" => 26941
	]
);