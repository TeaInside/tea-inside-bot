<?php

namespace Bot\Response\Command;

use Lang;
use Bot\Bot;
use Telegram as B;
use Bot\Abstraction\CommandFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class ShellExec extends CommandFoundation
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

	private function reportIncidentToSudoers()
	{
		
	}
	
	private function securityCheck()
	{
		
	}
	
	public function run()
	{
		$isRoot = false;
		if (defined("SUDOERS")) {
			if (in_array($this->b->user_id, SUDOERS)) {
				$isRoot = true;
			}
		}

		if (! $isRoot and ! $this->securityCheck()) {
			$msg = Lang::bind("{namelink} is not in the sudoers file. This incident will be reported.");
			$this->reportIncidentToSudoers()
		} else {
			$cmd = explode(" ", $this->b->text, 2);
			$msg = shell_exec($cmd[1]." 2>&1");
			$msg = $msg === "" ? "<pre>~</pre>" : "<pre>".htmlspecialchars($msg)."</pre>";
		}

		B::sendMessage(
			[
				"chat_id" 	 => $this->b->chat_id,
				"text"  	 => $msg,
				"parse_mode" => "HTML",
				"reply_to_message_id" => $this->b->msgid
			]
		);
	}
}