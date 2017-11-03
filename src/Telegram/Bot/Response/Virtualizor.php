<?php

namespace Telegram\Bot\Response;

use Telegram as B;
use Telegram\Bot\Bot;
use Telegram\Plugins\Virtualizor\Bridge;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Virtualizor
{

	/**
	 * Constructor.
	 *
	 * @param \Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	private function isVirtualizorAction()
	{
		$flag = false;
		if (substr($this->b->lowertext, 0, 5) === "<?php") {
			$st = new Bridge($this->b->text, "php");
			B::sendMessage(
				[
					"text" 				  => $st->exec(),
					"chat_id"			  => $this->b->chat_id,
					"reply_to_message_id" => $this->b->msgid
				]
			);
			$flag = true;
		}
		return $flag;
	}

	public function run()
	{
		return $this->isVirtualizorAction();
	}
}