<?php

namespace FakeWebhookTest;

use Bot\Bot;
use PHPUnit\Framework\TestCase;

class DirectTest extends TestCase
{
	public function testFake1()
	{
		$json = '{
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
    "text": "/sh Test"
}';
		$bot = new Bot($json);
		$this->assertTrue($bot->run());
	}
}
