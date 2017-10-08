<?php

namespace Handler\SaveEvent;

use DB;
use PDO;
use Handler\MainHandler;

final class GroupHandler
{
	/**
	 * @var Handler\MainHandler
	 */
	private $h;

	/**
	 * Constructor.
	 *
	 * @param Handler\MainHandler $handler
	 */
	public function __construct(MainHandler $handler)
	{
		$this->h = $handler;
	}

	/**
	 * Track change.
	 */
	public function track()
	{
		$st = DB::prepare("SELECT `username`,`name` FROM `a_groups` WHERE `group_id`=:group_id LIMIT 1;");
		pc($st->execute(
			[
				":group_id" => $this->h->chat_id
			]
		), $st);
		$st = $st->fetch(PDO::FETCH_NUM);
		if ($st === false) {
			return false;
		}
		if (
			$st[0] != $this->h->chatuname ||
			$st[1] != $this->h->chattitle
		) {
			return "change";
		}
		return true;
	}

	public function saveChange()
	{
		$st = DB::prepare("UPDATE `a_groups` SET `username`=:username, `name`=:name, `updated_at`=:updated_at WHERE `group_id`=:group_id LIMIT 1");
		pc($st->execute(
			[
				":username" 	=> $this->h->chatuname,
				":name"			=> $this->h->chattitle,
				":updated_at" 	=> date("Y-m-d H:i:s"),
				":group_id"		=> $this->h->chat_id,
			]
		), $st);
		$this->writeHistory();
		return true;
	}

	/**
	 * Save new group.
	 */
	public function saveNewGroup()
	{
		$st = DB::prepare("INSERT INTO `a_groups` (`group_id`, `username`, `name`, `private_link`, `photo`, `created_at`, `updated_at`) VALUES (:group_id, :username, :name, :private_link, :photo, :created_at, :updated_at);");
		pc($st->execute(
			[
				":group_id" 	=> $this->h->chat_id,
				":username"		=> $this->h->chatuname,
				":name"			=> $this->h->chattitle,
				":private_link"	=> null,
				":photo"		=> null,
				":created_at"	=> date("Y-m-d H:i:s"),
				":updated_at"	=> null
			]
		), $st);
		$st = DB::prepare("INSERT INTO `groups_setting` (`group_id`, `max_warn`, `welcome_message`) VALUES (:group_id, 3, NULL);");
		pc($st->execute([":group_id" => $this->h->chat_id]), $st);
		$this->writeHistory();
		return true;
	}

	/**
	 * Write history.
	 */
	private function writeHistory()
	{
		$st = DB::prepare("INSERT INTO `groups_history` (`group_id`, `username`, `name`, `created_at`) VALUES (:group_id, :username, :name, :created_at);");
		pc($st->execute(
			[
				":group_id" 	=> $this->h->chat_id,
				":username" 	=> $this->h->chatuname,
				":name"			=> $this->h->chattitle,
				":created_at"	=> date("Y-m-d H:i:s")
			]
		), $st);
		return true;
	}
}