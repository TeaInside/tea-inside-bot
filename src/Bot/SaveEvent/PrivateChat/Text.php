<?php

namespace Bot\SaveEvent\PrivateChat;

use Bot\Bot;
use Contracts\SaveEvent;

class Text implements SaveEvent
{

	/**
	 * @var \Bot\Bot
	 */
	private $b;

	/**
	 * Constructor.
	 *
	 * @param \Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	/**
	 * Save event.
	 */
	public function save()
	{
		
	}
}