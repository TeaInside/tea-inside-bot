<?php

namespace FakeWebhookTest;

use Curl;
use Bot\Bot;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
	public function testFirst()
	{
		shell_exec(PHP_BINARY." -S 127.0.0.1:9000 -t ".BASEPATH."/public >> /dev/null 2>&1 &");
		$ch = new Curl("http://127.0.0.1:9000/webhook.php");
		$ch->post('{
    "message_id": 3461593,
    "from": {
        "id": 243692601,
        "is_bot": false,
        "first_name": "Ammar",
        "last_name": "F",
        "username": "ammarfaizi2",
        "language_code": "en-US"
    },
    "chat": {
        "id": 243692601,
        "first_name": "Ammar",
        "last_name": "F",
        "username": "ammarfaizi2",
        "type": "private"
    },
    "date": 1508600597,
    "text": "qwe"
}');
		$out = $ch->exec();
        var_dump($out);
		$this->assertTrue($ch->info['http_code'] === 200);
	}
}