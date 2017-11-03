<?php

namespace LINE\Bot\Response;

use LINE;

trait CommandRoutes
{
	private function writeRoutes()
	{
		$st = explode(" ", $this->b->text, 2);
		
		$this->route(function() use ($st){
			var_dump($st);
			return $st[0] === "/google";
		}, function() use ($st) {
			$st = new \Plugins\SearchEngine\GoogleSearch\GoogleSearch($st[1]);
			$st = $st->exec();
			LINE::push(
				[
					"to" => $this->b->chat_id,
					"messages" => [
						[
							"type" => "text",
							"text" => $st
						]
					]
				]
			);
		});
	}
}