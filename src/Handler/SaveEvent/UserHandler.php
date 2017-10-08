<?php

namespace Handler\SaveEvent;

use DB;
use PDO;
use Handler\MainHandler;

final class UserHandler
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
		$st = DB::prepare("SELECT `username`,`name` FROM `a_users` WHERE `userid`=:userid LIMIT 1;");
		pc($st->execute(
			[
				":userid" => $this->h->userid
			]
		), $st);
		$st = $st->fetch(PDO::FETCH_NUM);
		if ($st === false) {
			return false;
		}
		if (
			$st[0] != $this->h->username ||
			$st[1] != $this->h->name
		) {
			return "change";
		}
		return true;
	}

	public function saveChange()
	{
		$st = DB::prepare("UPDATE `a_users` SET `username`=:username, `name`=:name WHERE `userid`=:userid LIMIT 1;");
		pc($st->execute(
			[
				":username" => $this->h->username,
				":name"		=> $this->h->name,
				":userid"	=> $this->h->userid
			]
		), $st);
		$this->writeHistory();
		return true;
	}


	public function saveNewUser()
	{
		if ($this->h->chattype === "private") {
			$priv = 1 xor $group = 0;
		} else {
			$priv = 0 xor $group = 1;
		}
		$st = DB::prepare("INSERT INTO `a_users` (`userid`, `username`, `name`, `photo`, `private_msg_count`, `group_msg_count`, `created_at`, `updated_at`) VALUES (:userid, :username, :name, :photo, :private_msg_count, :group_msg_count, :created_at, :updated_at);");
		pc($st->execute(
			[
				":userid" 				=> $this->h->userid,
				":username"				=> $this->h->username,
				":name"					=> $this->h->name,
				":photo"				=> null,
				":private_msg_count"	=> $priv,
				":group_msg_count"		=> $group,
				":created_at"			=> date("Y-m-d H:i:s"),
				":updated_at"			=> null
			]
		),$st);
		$this->writeHistory();
		return true;
	}

	public function saveCountMessage($type)
	{
		if ($type === "private") {
			$st = DB::prepare("UPDATE `a_users` SET `private_msg_count`=`private_msg_count`+1 WHERE `userid`=:userid LIMIT 1;");
			pc($st->execute([":userid" => $this->h->userid]), $st);
		} else {
			$st = DB::prepare("UPDATE `a_users` SET `group_msg_count`=`group_msg_count`+1 WHERE `userid`=:userid LIMIT 1;");
			pc($st->execute([":userid" => $this->h->userid]), $st);
			$st = DB::prepare("UPDATE `a_groups` SET `msg_count`=`msg_count`+1 WHERE `group_id`=:group_id LIMIT 1;");
			pc($st->execute([":group_id" => $this->h->chat_id]), $st);
		}
	}

	private function writeHistory()
	{
		$st = DB::prepare("INSERT INTO `users_history` (`userid`, `username`, `name`, `photo`, `created_at`) VALUES (:userid, :username, :name, :photo, :created_at);");
		pc($st->execute(
			[
				":userid"		=> $this->h->userid,
				":username" 	=> $this->h->username,
				":name"			=> $this->h->name,
				":photo"		=> null,
				":created_at" 	=> date("Y-m-d H:i:s")
			]
		), $st);
	}
}