<?php

require __DIR__."/../../autoload.php";

use Telegram as B;

$msg = "
<b>Circle CI Report</b>:
- Permanently added 'github.com,192.30.253.113' (RSA) to the list of known hosts.

PHP Version	: 7.1.0
Timezone	: Asia/Jakarta
PHPUnit		: ".trim(shell_exec("phpunit --version"))."
Time		: ".(time() - file_get_contents("flag_time.tmp"))."
<b>Success! Your tests passed on CircleCI!</b>
";

B::sendMessage(
	[
		"text"		 => $msg,
		"chat_id"	 => -1001128531173,
		"parse_mode" => "HTML"
	]
);