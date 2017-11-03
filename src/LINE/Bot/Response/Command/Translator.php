<?php

namespace LINE\Bot\Response\Command;

use LINE;
use LINE\Bot\Bot;
use LINE\Bot\Abstraction\CommandFoundation;
use Plugins\SearchEngine\GoogleSearch\GoogleSearch;

class Translator extends CommandFoundation
{
	/**
	 * @var \LINE\Bot\Bot
	 */
	private $b;
	
	/**
	 * Constructor.
	 *
	 * @param \LINE\Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

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