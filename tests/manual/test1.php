<?php

require __DIR__."/../../autoload.php";

use Telegram as B;

B::sendMessage(
	[
		"text"		=> "Hello World!",
		"chat_id"	=> -1001128531173
	]
);