<?php

require __DIR__."/../../autoload.php";

use Telegram as B;

$msg = "
<b>Circle CI</b>:
PHP Version	: 7.1.0
Timezone	: Asia/Jakarta
PHPUnit		: ".trim(shell_exec("phpunit --version"))."
";

B::sendMessage(
	[
		"text"		 => $msg,
		"chat_id"	 => -1001128531173,
		"parse_mode" => "HTML"
	]
);