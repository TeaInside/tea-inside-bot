<?php

namespace tests\Telegram\FakeWebhook;

include_once BASEPATH."/config/telegram.php";

use Telegram\Bot\Bot;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{

    /**
     * Test webhook 1
     */
    public function testFakeWebhook()
    {
        $json = json_encode(
            [
                "update_id" => rand(10000000, 99999999),
                "message" => [
                    "message_id" => rand(1, 100),
                    "from" => [
                        "id"            => 243692601,
                        "is_bot"        => false,
                        "first_name"    => "Ammar",
                        "last_name"     => "Faizi",
                        "username"      => "ammarfaizi2",
                        "language_code"     => "en-US"
                    ],
                    "chat" => [
                        "id"        => -1001134449138,
                        "title"         => "Test ".rand(1, 10),
                        "type"      => "supergroup"
                    ],
                    "date" => time(),
                    "text" => "ping"
                ]
            ]
        );

        try {
            $app = new Bot($json);
            $app->run();
            $action = true;
        } catch (\Error $e) {
            var_dump($e->getMessage());
            $action = false;
        } catch (\PDOException $e) {
            $action = true;
        }
        $this->assertTrue($action);
    }
}

/*
 JSON Sample
{
    "update_id": 344377181,
    "message": {
        "message_id": 835,
        "from": {
            "id": 243692601,
            "is_bot": false,
            "first_name": "Ammar",
            "last_name": "F.",
            "username": "ammarfaizi2",
            "language_code": "en-US"
        },
        "chat": {
            "id": -1001134449138,
            "title": "SOLID SQUARE",
            "type": "supergroup"
        },
        "date": 1509703368,
        "text": "ping"
    }
}
*/
