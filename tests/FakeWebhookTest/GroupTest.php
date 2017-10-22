<?php

namespace FakeWebhookTest;

use Bot\Bot;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
	public function test1()
	{
		$st = new Bot('{
    "update_id": 344318104,
    "message": {
        "message_id": 390552,
        "from": {
            "id": 93827681,
            "is_bot": false,
            "first_name": "V",
            "last_name": "Alen",
            "username": "brian1494"
        },
        "chat": {
            "id": -1001053021994,
            "title": "Werewolf Brewmaster",
            "type": "supergroup"
        },
        "date": 1508602664,
        "text": "ngasih nya pas ga maen ww la"
    }
}');	
		$st->run();
		$this->assertTrue(true);
	}
}