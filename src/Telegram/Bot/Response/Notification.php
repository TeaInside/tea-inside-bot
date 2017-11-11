<?php

namespace Telegram\Bot\Response;

use DB;
use Telegram as B;
use Telegram\Bot\Bot;

class Notification
{
	private $ndata = [];

	public function __construct(Bot $b)
	{
		$this->b = $b;
		$this->buildContext();
	}

	public function run()
	{
		if ($this->shouldReport()) {
			$this->notify();
		}
	}

	private function isKnownUser($v, $type = "username")
	{
		$st = DB::prepare("SELECT `user_id` FROM `a_users` WHERE `{$type}` LIKE :bind LIMIT 1;");
		$st->execute([":bind" => $v]);
		$st = $st->fetch(PDO::FETCH_NUM);
		if ($st) {
			return $st[0];
		} else {
			return false;
		}
	}

	private function shouldReport()
	{
		var_dump($this->mention);die;
		foreach ($this->mention as $val) {
			foreach ($val['username'] as $v) {
				$v =  $this->isKnownUser($v);
				$v and $this->buildReply("mention", $v);
			}
			foreach ($val['user_id'] as $v) {
				$v =  $this->isKnownUser($v, "user_id");
				$v and $this->buildReply("mention", $v);
			}
		}
		return sizeof($this->ndata);
	}

	private function buildReply($type, $userid)
	{
		$msg = $this->buildMessage($type);
		$this->ndata[] = [
			"chat_id" => $userid,
			"text"  => $msg,
			"parse_mode" => "HTML"
		];
	}

	private function buildMessage($type)
	{
		$name = "<a href=\"tg://user?id={$this->b->user_id}\">".htmlspecialchars($this->b->name, ENT_QUOTES, 'UTF-8')."</a>";
		if ($this->b->chatuname) {
			$chatroom = "<a href=\"https://t.me/{$this->b->chatuname}/{$this->b->msgid}\">".htmlspecialchars($this->b->chattitle)."</a>";
		} else {
			$chatroom = "<b>".$this->b->chattitle."</b>";
		}
		switch ($type) {
			case 'mention':
				return "{$name} tagged you in {$chatroom}\n\n<pre>".htmlspecialchars($this->b->text)."</pre>";
				break;
			
			default:
				break;
		}
	}

	private function buildContext()
	{
		$getUsername = []; $getId = [];
		foreach ($entities as $val) {
			if ($val['type'] === "mention") {
				$getUsername[] = substr($this->lowertext, $val['offset'], $val['length']);
			} elseif ($val['type'] === "text_mention" && $val['user']['is_bot'] === false) {
				$getID[] = $val['user']['id'];
			}
		}
		$this->mention = [
			"username" => $getUsername,
			"user_id" => $getID
		];
		$this->replyto = [

		];
	}

	private function notify()
	{
		foreach ($this->ndata as $val) {
			B::sendMessage($val);
		}
	}
}