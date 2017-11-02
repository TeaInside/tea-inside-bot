<?php

namespace LINE\Bot;

use LINE;
use Bridge;
use LINE\Bot\Bot;

class Response
{

	/**
	 * @var \LINE\Bot\Bot
	 */
	private $b;

	/**
	 * Constructor.
	 *
	 * @param \LINE\Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	public function run()
	{
		$this->sendToTelegram();
	}

	private function sendToTelegram()
	{
		if ($this->b->msgtype === "text") {
			$u = json_decode(LINE::profile($this->b->userid)['content'], true);
			isset($u['displayName']) or $u['displayName'] = $this->b->userid;
			$msg = "<b>".htmlspecialchars($u['displayName'])."</b>\n<pre>".htmlspecialchars($this->b->text)."</pre>";
			Bridge::go("telegram/action_cli.php", ["sendMessage", urlencode(json_encode(
				[
					"text" => $msg,
					"chat_id" => -1001134449138,
					"parse_mode" => "HTML"
				]
			))]);
		}
	}
}

