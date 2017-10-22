<?php

namespace Bot;

use Bot\SaveEvent\UserEvent;
use Bot\SaveEvent\GroupEvent;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
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
		$st = new UserEvent($this->b);
		if ($st->run()) {
			$st = new GroupEvent($this->b);
			$st->run();
		}
		if ($this->b->chattype === "private") {
			$ns = "\\Bot\\SaveEvent\\PrivateChat\\";
		} else {
			$ns = "\\Bot\\SaveEvent\\GroupChat\\";
		}

		switch ($this->b->msgtype) {
			case 'text':
				$ns.= "Text";
				break;
			default:
				throw new \Exception("Unknown event", 1);
				break;
		}
		$st = new $ns($this->b);
		$st->save();
	}
}