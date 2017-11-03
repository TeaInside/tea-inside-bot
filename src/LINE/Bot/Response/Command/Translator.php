<?php

namespace LINE\Bot\Response\Command;

use LINE\Bot\Bot;

class Translator extends CommandFoudnation
{
	public function googletranslate()
	{
		$st = explode(" ", $this->b->text, 4);
        isset($st[1],$st[2],$st[3]) and
        $st = new \Plugins\Translator\GoogleTranslate\GoogleTranslate($st[3], $st[1], $st[2]);
        $st = $st->exec();
        print LINE::push(
            [
            "to" => $this->b->chat_id,
            "messages" => [
            [
            "type" => "text",
            "text" => $st
            ]
            ]
            ]
        )['content'];
	}
}