<?php

namespace Bot\SaveEvent;

use DB;
use PDO;
use Bot\Bot;
use Bot\Abstraction\EventFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class GroupEvent extends EventFoundation
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

	private function trackEvent()
	{
		$st = DB::prepare("SELECT `username`,`name`,`private_link`,`photo` WHERE `group_id`=:group_id LIMIT 1;");
		pc($st->execute([":group_id" => $this->b->group_id]), $st);
		$st = $st->fetch(PDO::FETCH_ASSOC);
		if (! $st) {
			return false;
		}

		if (
			true
		) {
			
		}
	}

	public function run()
	{

	}
}