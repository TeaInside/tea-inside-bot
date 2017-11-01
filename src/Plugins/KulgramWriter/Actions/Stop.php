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
				unlink($this->lockfile);
				unlink($this->lockfile.".start");
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
				B::sendMessage(
					[
						"text" => "Catatan berhasil dienkripsi!\n\nRaw data : ".$this->dumpMessages(),
						"chat_id" => $this->b->chat_id
					]
				);
			}		
		}
		return false;
	}

	private function dumpMessages()
	{
		$start = date("Y-m-d H:i:s", $this->infodata['list'][$this->infodata['count'] - 1]['start']);
		$end = date("Y-m-d H:i:s", $this->infodata['list'][$this->infodata['count'] - 1]['end']);
		$st = DB::prepare($q = "SELECT `c`.`name`,`c`.`user_id`,`a`.`message_id`, `a`.`reply_to_message_id` AS `reply_to`,`a`.`type`,`b`.`text`,`b`.`file`,`a`.`created_at` AS `time` FROM `group_messages` AS `a` INNER JOIN `group_messages_data` AS `b` ON `a`.`msg_uniq`=`b`.`msg_uniq` INNER JOIN `a_users` AS `c` ON `a`.`user_id`=`c`.`user_id` WHERE `a`.`group_id`=:group_id AND `a`.`created_at` >= '{$start}' AND `a`.`created_at` <= '{$end}';");
		var_dump($q);
		pc($st->execute(
			[
				":group_id" => $this->b->chat_id
			]
		), $st);
		$this->infodata['list'][$this->infodata['count'] - 1]['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
		file_put_contents($this->tmpdir."/data.json", self::crypt(json_encode($this->infodata['list'][$this->infodata['count'] - 1]), $key), LOCK_EX);
		shell_exec("cd ".$this->tmpdir." && zip ".$this->datapath."/".$this->infodata['count'].".zip * && rm -rfv *");
		return $this->datapath."/".$this->infodata['count'].".zip\nDownload : https://crayner.webhook.ga/storage/data/kulgram/data/".$this->b->chat_id."/".$this->infodata['count'].".zip";
	}
}