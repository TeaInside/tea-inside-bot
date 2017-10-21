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
		
	}
}