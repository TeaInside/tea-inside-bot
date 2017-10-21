<?php

namespace Bot;

class SaveEvent
{	

	/**
	 * @var \Bot\Bot
	 */
	private $bot;

	/**
	 * Constructor.
	 *
	 * @param \Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	public function run()
	{
		if ($this->b->chattype === "private") {
			$this->ns = "\\Bot\\SaveEvent\\PrivateChat";
		} else {
			$this->ns = "\\Bot\\SaveEvent\\GroupChat";
		}
	}
}