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
			$ns = "\\Bot\\SaveEvent\\PrivateChat";
		} else {
			$ns = "\\Bot\\SaveEvent\\GroupChat";
		}

		switch ($this->b->msgtype) {
			case 'text':
				
				break;
			
			default:
				# code...
				break;
		}
	}
}