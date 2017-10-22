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
    "update_id": 344317636,
    "message": {
        "message_id": 23062,
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
        "date": 1508600922,
        "text": "\/sh echo \"server test (sh)\"",
        "entities": [
            {
                "offset": 0,
                "length": 3,
                "type": "bot_command"
            }
        ]
    }
}');
		$out = $ch->exec();
		$this->assertTrue($ch->info['http_code'] === 200);
	}
}