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
		$st = DB::prepare("SELECT `username`,`name`,`private_link`,`photo` FROM `a_groups` WHERE `group_id`=:group_id LIMIT 1;");
		pc($st->execute([":group_id" => $this->b->chat_id]), $st);
		$st = $st->fetch(PDO::FETCH_ASSOC);
		if (! $st) {
			return false;
		}

		if (
			$st['username'] !== $this->b->chatuname ||
			$st['name']		!== $this->b->chattitle
		) {
			return "update";
		}
		return "known";
	}

	private function updateGroupInfo()
	{
		$st = DB::prepare("UPDATE `a_groups` SET `username`=:username, `name`=:name, `private_link`=NULL, `updated_at`=:updated_at, `msg_count`=`msg_count`+1 WHERE `group_id`=:group_id LIMIT 1;");
		pc($st->execute(
			[
				":username" 	=> $this->b->username,
				":name"			=> $this->b->name,
				":updated_at"	=> date("Y-m-d H:i:s"),
				":group_id"		=> $this->b->chat_id
			]
		), $st);
		$this->writeGroupHistory();
		return true;
	}

	private function increaseMessageCount()
	{
		$st = DB::prepare("UPDATE `a_groups` SET `msg_count`=`msg_count`+1 WHERE `group_id`=:group_id LIMIT 1;");
		pc($st->execute([":group_id" => $this->b->chat_id]), $st);
		return true;
	}

	private function saveNewGroup()
	{
		$st = DB::prepare("INSERT INTO `a_groups` (`group_id`, `username`, `name`, `private_link`, `photo`, `msg_count`, `created_at`, `updated_at`) VALUES (:group_id, :username, :name, NULL, NULL, 1, :created_at, NULL);");
		pc($st->execute(
			[
				":group_id" 	=> $this->b->chat_id,
				":name"			=> $this->b->chattitle,
				":username"		=> $this->b->chatuname,
				":created_at"	=> date("Y-m-d H:i:s")
			]
		), $st);
		return true;
	}

	public function run()
	{
		$track = $this->trackEvent();
		if ($track === "update") {
			$this->updateGroupInfo();
		} elseif ($track === "known") {
			$this->increaseMessageCount();
		} else {
			$this->saveNewGroup();
		}
	}
}