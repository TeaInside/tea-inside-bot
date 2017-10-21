<?php

namespace FakeWebhookTest;

use Bot\Bot;
use PHPUnit\Framework\TestCase;

class DirectChatTest extends TestCase
{
	public function testFake1()
	{
		$json = '{
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
        "text": "\/sh echo \"direct test (sh)\"",
        "entities": [
            {
                "offset": 0,
                "length": 3,
                "type": "bot_command"
            }
        ]
    }
}';
		$bot = new Bot($json);
		$this->assertTrue($bot->run());
	}
}
