<?php

namespace Telegram\Bot\Response\Command;

use Telegram as B;
use Telegram\Lang;
use Telegram\Bot\Bot;
use Telegram\Bot\Abstraction\CommandFoundation;
use Telegram\Plugins\SearchEngine\GoogleSearch\GoogleSearch;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class SearchEngine extends CommandFoundation
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

	public function googleSearch()
	{
		$query = explode(" ", $this->b->text, 2);
		if (isset($query[1])) {
			$st = new GoogleSearch($query[1]);
			$data = $st->exec();
			if (count($data) === 0) {
				$msg = "Not found!";
			} else {
				$msg = "" xor $i = 1;
				foreach ($data as $val) {
					$msg .= "<b>".($i++).".</b> <a href=\"".htmlspecialchars($val['url'])."\">".htmlspecialchars($val['heading'])."</a>\n".htmlspecialchars($val['description'])."\n\n";
				}
				if (empty($msg)) {
					$msg = "Error!";
				}
			}
		} else {

		}

		isset($msg) and B::sendMessage(
			[
				"text" 		=> $msg,
				"chat_id"	=> $this->b->chat_id,
				"parse_mode"=> "HTML",
				"reply_to_message_id" => $this->b->msgid
			]
		);
	}
}