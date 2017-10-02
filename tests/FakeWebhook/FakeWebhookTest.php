<?php

namespace FakeWebhook;

use Bot;
use PHPUnit\Framework\TestCase;

class FakeWebhookTest extends TestCase
{
    public function testInit()
    {
        $input = '{
		    "update_id": 344262043,
		    "message": {
		        "message_id": 27024,
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
		            "title": "Tea Inside",
		            "type": "private"
		        },
		        "date": 1506750221,
		        "text": ""
		    }
		}';

        $app = new Bot($input);
        $app->run();
        $this->assertTrue(true);
    }
}
