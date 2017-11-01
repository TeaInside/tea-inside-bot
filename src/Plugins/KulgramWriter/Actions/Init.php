<?php

namespace Plugins\KulgramWriter\Actions;

use Telegram as B;
use Plugins\KulgramWriter\KulgramWriterFoundation;

class Init extends KulgramWriterFoundation
{
	public function run()
	{
		$l = $this->b->lowertext;
		$a = explode("topik saat ini", $l, 2);
		if (! isset($a[1])) {
			$a = explode("topik hari ini", $l, 2);
			if (! isset($a[1])) {
				$a = explode("materi hari ini", $l, 2);
				if (! isset($a[1])) {
					$a = explode("materi kulgram hari ini", $l, 2);
					if (! isset($a[1])) {
						$a = explode("topik kulgram hari ini", $l, 2);
						if (! isset($a[1])) {
							return false;
						}
					}
				}
			}
		}
		
		$b = explode("oleh", $a[1], 2);
		$author = isset($b[1]) ? ucwords(strtolower($b[1])) : $this->b->name;
		$title  = strtoupper(trim($a[1]));
		file_put_contents($this->lockfile, json_encode(
			[
				"start" => null,
				"title" => $title,
				"author" => $author,
				"init_time" => time()
			]
		));
		B::sendMessage(
			[
				"text" => "Baiklah, topik saat ini adalah \"<b>".htmlspecialchars($title)."</b>\" oleh <b>".htmlspecialchars($author)."</b>",
				"chat_id" => $this->b->chat_id,
				"parse_mode" => "HTML"
			]
		);
	}
}