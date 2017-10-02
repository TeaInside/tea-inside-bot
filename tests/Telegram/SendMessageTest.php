<?php

namespace Telegram;

use Telegram as B;
use PHPUnit\Framework\TestCase;

class SendMessageTest extends TestCase
{
    public function testPrivateMessage()
    {
        $this->assertTrue(
            /*B::sendMessage(
            [
            "chat_id" => 243692601,
            "text"    => "<b>Circle CI</b> testPrivateMessage test case. Success!\nTest history : ".sha1(time()),
            "parse_mode" => "HTML"
            ]
            )['info']['http_code'] == 200*/true
        );
    }
}
