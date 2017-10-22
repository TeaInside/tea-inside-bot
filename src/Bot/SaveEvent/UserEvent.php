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
class UserEvent extends EventFoundation
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
	 * Track event.
	 */
	private function trackEvent()
	{
		$st = DB::prepare("SELECT `username`,`name`,`photo` FROM `a_users` WHERE `user_id`=:user_id LIMIT 1;");
		pc($st->execute([":user_id" => $this->b->user_id]), $st);
		$st = $st->fetch(PDO::FETCH_ASSOC);
		if (! $st) {
			return false;
		}

		if (
			$st['username'] !== $this->b->username ||
			$st['name']     !== $this->b->name
		) {
			return "update";
		}
		return "known";
	}

	/**
	 * Update user info.
	 */
	private function updateUserInfo()
	{
		$add = $this->b->chattype === "private" ? "`private_msg_count`=`private_msg_count`+1" : "`group_msg_count`=`group_msg_count`+1";
		$st = DB::preapre("UPDATE `a_users` SET `username`=:username, `name`=:name, `photo` = NULL, `updated_at`=:updated_at, {$add} WHERE `user_id`=:user_id LIMIT 1;");
		pc($st->execute(
			[
				":username" 	=> $this->b->username,
				":name"			=> $this->b->name,
				":updated_at"	=> date("Y-m-d H:i:s"),
				":user_id" 		=> $this->b->user_id
			]
		), $st);
		$this->writeUserHistory();
		return true;
	}

	/**
	 * Increase message count.
	 */
	private function increaseMessageCount()
	{
		$add = $this->b->chattype === "private" ? "`private_msg_count`=`private_msg_count`+1" : "`group_msg_count`=`group_msg_count`+1";
		$st = DB::prepare("UPDATE `a_users` SET `updated_at`=:updated_at, {$add} WHERE `user_id`=:user_id LIMIT 1;");
		pc($st->execute(
			[
				":user_id" 		=> $this->b->user_id,
				":updated_at"	=> date("Y-m-d H:i:s")
			]
		), $st);
		return true;
	}

	/**
	 * Save new user.
	 */
	private function saveNewUser()
	{
		$pr = $this->b->chattype === "private" ? 1 : 0;
		$gr = $pr ? 0 : 1;
		$st = DB::prepare("INSERT INTO `a_users` (`user_id`, `username`, `name`, `photo`, `private_msg_count`, `group_msg_count`, `created_at`, `updated_at`) VALUES (:user_id, :username, :name, NULL, {$pr}, {$gr}, :created_at, NULL);");
		pc($st->execute(
			[
				":user_id" 		=> $this->b->user_id,
				":username"		=> $this->b->username,
				":name"			=> $this->b->name,
				":created_at"	=> date("Y-m-d H:i:s")
			]
		), $st);
		$this->writeUserHistory();
		return true;
	}

	/**
	 * Write user history.
	 */
	private function writeUserHistory()
	{
		$st = DB::prepare("INSERT INTO `users_history` (`user_id`, `username`, `name`, `photo`, `created_at`) VALUES (:user_id, :username, :name, NULL, :created_at)");
		pc($st->execute(
			[
				":user_id" 		=> $this->b->user_id,
				":username" 	=> $this->b->username,
				":name"			=> $this->b->name,
				":created_at"	=> date("Y-m-d H:i:s")
			]
		), $st);
		return true;
	}

	/**
	 * Run user event.
	 */
	public function run()
	{
		$track = $this->trackEvent();
		if ($track === "update") {
			$this->updateUserInfo();
		} elseif ($track === "known") {
			$this->increaseMessageCount();
		} else {
			$this->saveNewUser();
		}
		return $this->b->chattype !== "private";
	}
}