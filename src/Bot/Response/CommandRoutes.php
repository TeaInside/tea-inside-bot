<?php

namespace Bot\Response;

trait CommandRoutes
{
	private function buildCMDRoutes()
	{
		$this->set(function()
		{
			$st = explode(" ", $this->b->lowertext, 2);
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

		$this->set(function()
		{
			$st = explode(" ", $this->b->lowertext, 2);
			$st = explode("@", $st[0]);
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
			)['content']);
		});
	}
}