<?php

namespace Plugins\KulgramWriter;

use Bot\Bot;

abstract class KulgramWriterFoundation
{
	protected $b;
	
	protected $path;
	
	protected $lockfile;
	
	protected $datafile;
	
	protected $infofile;
	
	protected $initfile;
	
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
		$this->path = data."/kulgram/";
		$this->lockfile = $this->path."/lock/".$bot->chat_id.".lock";
		$this->datafile = $this->path."/data/".$bot->chat_id.".data";
		$this->infofile = $this->path."/info/".$bot->chat_id.".info";
		$this->initfile = $this->path."/init/".$bot->chat_id;
		is_dir($a=$this->path."/lock") or mkdir($a);
		is_dir($a=$this->path."/data") or mkdir($a);
		is_dir($a=$this->path."/info") or mkdir($a);
		is_dir($a=$this->path."/init") or mkdir($a);
	}
}