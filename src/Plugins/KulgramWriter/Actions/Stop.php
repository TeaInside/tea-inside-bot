<?php

namespace Plugins\KulgramWriter\Actions;

use DB;
use PDO;
use Telegram as B;
use Plugins\KulgramWriter\KulgramWriterFoundation;

class Stop extends KulgramWriterFoundation
{
	public function run()
	{
		if (file_exists($this->lockfile)) {
			$this->getInfo();
			if ($this->infodata['status'] === "start") {
				$this->infodata['status'] = "stop";
				$this->infodata['list'][$this->infodata['count'] - 1]['end'] = time();
				$this->writeInfo();
				B::sendMessage(
					[
						"text" => "Siap... catatan sudah dihentikan.",
						"chat_id" => $this->b->chat_id
					]
				);
				B::sendMessage(
					[
						"text" => "Mengenkripsi catatan...",
						"chat_id" => $this->b->chat_id
					]
				);
				$this->dumpMessages();
				B::sendMessage(
					[
						"text" => "Catatan berhasil dienkripsi!\n\n".$this->datapath."/".$this->infodata['count'],
						"chat_id" => $this->b->chat_id
					]
				);
			}		
		}
		return false;
	}

	private function dumpMessages()
	{
		$start = $this->infodata['list'][$this->infodata['count'] - 1]['start'];
		$end = $this->infodata['list'][$this->infodata['count'] - 1]['end'];
		$st = DB::prepare("SELECT `c`.`name`,`c`.`user_id`,`a`.`message_id`, `a`.`reply_to_message_id`,`a`.`type`,`b`.`text`,`b`.`file` FROM `group_messages` AS `a` INNER JOIN `group_messages_data` AS `b` ON `a`.`msg_uniq`=`b`.`msg_uniq` INNER JOIN `a_users` AS `c` ON `a`.`user_id`=`c`.`user_id` WHERE `a`.`group_id`=:group_id AND `a`.`created_at` >= {$start} AND `a`.`created_at` <= {$end};");
		$st->execute(
			[
				":group_id" => $this->b->chat_id
			]
		);
		$data = $st->fetchAll(PDO::FETCH_ASSOC);
		file_put_contents($this->datapath."/".$this->infodata['count'], json_encode($data), LOCK_EX);
	}
}