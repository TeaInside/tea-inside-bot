<?php

require __DIR__."/../../config/telegram.php";
require __DIR__."/../../autoload.php";

$a = file_get_contents("php://input");
$a = json_encode(json_decode($a), 128);

Telegram::sendMessage(
	[
		"text" => $a,
		"chat_id" => 243692601
	]
);