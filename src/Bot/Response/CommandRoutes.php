<?php

namespace Bot\Response;

use Telegram as B;

trait CommandRoutes
{
	private function buildCMDRoutes()
	{
		$st = explode(" ", $this->b->lowertext, 2);
		$st = explode("@", $st[0]);


		/**
		 * Shell exec
		 */
		$this->set(function() use ($st)
		{
			return 
				$st[0] === "/sh"  	 ||
				$st[0] === "!sh" 	 ||
				$st[0] === "~sh" 	 ||
				$st[0] === "sh"  	 ||
				$st[0] === "/shexec" || 
				$st[0] === "!shexec" ||
				$st[0] === "~shexec" ||
				$st[0] === "shexec";
		}, "ShellExec@run");


		/**
		 * Ping bot.
		 */
		$this->set(function() use ($st)
		{
			return 
				$st[0] === "/ping"   ||
				$st[0] === "!ping" 	 ||
				$st[0] === "~ping" 	 ||
				$st[0] === "ping";
		}, function(){
			$start = microtime(true);
			$st = json_decode(B::sendMessage(
				[
					"text" 	  	          => "Pong!",
					"chat_id" 			  => $this->b->chat_id,
					"reply_to_message_id" => $this->b->msgid
				]
			)['content'], true);
			B::editMessageText(
				[
					"chat_id" => $this->b->chat_id,
					"message_id" => $st['result']['message_id'],
					"text" => "Pong!\n".((time() - $this->b->date) + round(microtime(true) - $start,  2))." s"
				]
			);
		});


		/**
		 * Ban user
		 */
		$this->set(function() use ($st)
		{
			return 
				$st[0] === "/ban"    ||
				$st[0] === "!ban" 	 ||
				$st[0] === "~ban";
		}, "AdminHammer@ban");


		/**
		 * Translate
		 */
		$this->set(function() use ($st)
		{
			return
				$st[0] === "/tl"   		||
				$st[0] === "!tl" 	 	||
				$st[0] === "~tl" 	 	||
				$st[0] === "/translate"	||
				$st[0] === "!translate" ||
				$st[0] === "~translate";
		}, "Translator@googleTranslate");
		

		/**
		 * Translate replied message
		 */
		$this->set(function() use ($st)
		{
			return
				$st[0] === "/tlr"   	||
				$st[0] === "!tlr" 	 	||
				$st[0] === "~tlr" 	 	||
				$st[0] === "/trl"		||
				$st[0] === "!trl" 		||
				$st[0] === "~trl";
		}, "Translator@rgoogleTranslate");
	}
}