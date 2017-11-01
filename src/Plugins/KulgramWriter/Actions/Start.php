<?php

namespace Plugins\KulgramWriter\Actions;

use Telegram as B;
use Plugins\KulgramWriter\KulgramWriterFoundation;

class Start extends KulgramWriterFoundation
{
	public function run()
	{
		if (file_exists($this->lockfile)) {
			
		}
		return false;
	}
}