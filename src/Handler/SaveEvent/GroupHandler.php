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
				":updated_at" 	=> date("Y-m-d H:i:s")
				":group_id"		=> $this->h->chat_id,
			]
		), $st);
		$this->writeHistory();
		return true;
	}

	public function saveNewGroup()
	{
		$st = DB::preapre("INSERT INTO `a_groups` (`group_id`, `username`, `name`, `private_link`, `photo`, `created_at`, `updated_at`) VALUES (:group_id, :username, :name, :private_link, :photo, :created_at, :updated_at);");
		pc($st->execute(
			[
			]
		), $st);
		$this->writeHistory();
		return true;
	}

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