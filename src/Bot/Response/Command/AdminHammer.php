<?php

namespace Bot\Response\Command;

use DB;
use PDO;
use Lang;
use Bot\Bot;
use Telegram as B;
use Bot\Abstraction\CommandFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class AdminHammer extends CommandFoundation
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
	 * @return bool
	 */
	private function isAdmin()
	{
		if ($this->chattype === "private") {
			return false;
		}
		$st = DB::prepare("SELECT `user_id` FROM `groups_admin` WHERE `group_id`=:group_id AND `user_id`=:user_id LIMIT 1;");
		pc($st->execute(
			[
				":group_id" => $this->b->chat_id,
				":user_id"	=> $this->b->user_id
			]
		), $st);
		return (bool) $st->fetch(PDO::FETCH_NUM);
	}

	/**
	 * Ban
	 */
	public function ban()
	{
		if ($this->isAdmin()) {
			$msg = "Ok";
		} else {
			$msg = "You're not allowed to use this command!";
		}
		B::sendMessage(
			[
				"text" 			=> $msg,
				"chat_id"		=> $this->b->chat_id,
				"parse_mode"	=> "HTML"
			]
		);
	}

	/**
	 *
	 */
	public function kick()
	{
		if ($this->isAdmin()) {
			$msg = "Ok";
		} else {
			$msg = "You're not allowed to use this command!";
		}
		B::sendMessage(
			[
				"text" 			=> $msg,
				"chat_id"		=> $this->b->chat_id,
				"parse_mode"	=> "HTML"
			]
		);
	}

	/**
	 *
	 */
	public function warn()
	{
		if ($this->isAdmin()) {
			
		} else {
			$msg = "You're not allowed to use this command!";
		}
		B::sendMessage(
			[
				"text" 			=> $msg,
				"chat_id"		=> $this->b->chat_id,
				"parse_mode"	=> "HTML"
			]
		);
	}
}