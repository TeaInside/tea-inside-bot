<?php

namespace FakeWebhookTest;

use Bot\Bot;
use PHPUnit\Framework\TestCase;

class GroupChatTest extends TestCase
{
	public function testFake1()
	{
		$json = '{
    "update_id": 344283499,
    "message": {
        "message_id": 33081,
        "from": {
            "id": 243692601,
            "is_bot": false,
            "first_name": "Ammar",
            "last_name": "F",
            "username": "ammarfaizi2",
            "language_code": "en-US"
        },
        "chat": {
            "id": -1001128531173,
            "title": "Tea Inside",
            "type": "supergroup"
        },
        "date": 1507452015,
        "text": "/sh echo 123",
        "entities": [
            {
                "offset": 0,
                "length": 5,
                "type": "bot_command"
            }
        ]
    }
}';
		$bot = new Bot($json);
		$this->assertTrue($bot->run());
	}
}
