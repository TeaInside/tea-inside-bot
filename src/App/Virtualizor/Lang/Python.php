<?php

namespace App\Virtualizor\Lang;

use System\Contracts\App\Virtualizor\LangContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Python implements LangContract
{

	/**
	 * Constructor.
	 *
	 * @param string $pyCode
	 */
	public function __construct($pyCode)
	{
		$this->pyCode = $pyCode;
		$this->hash   = sha1($pyCode);
		$this->file   = VIRTUALIZOR_DIR."/python/".$this->hash.".py";
	}

	private function __init()
	{
		if (! is_dir(VIRTUALIZOR_DIR."/python")) {
			$exe = shell_exec("mkdir -p ".VIRTUALIZOR_DIR."/python");
			if (! is_dir(VIRTUALIZOR_DIR."/python")) {
				throw new \Exception($exe, 1);
			}
		}

		if (! file_exists($this->file)) {
			$handle = fopen($this->file, "w");
			fwrite($handle, $this->pyCode);
			fclose($handle);
		}
	}

	public function exec()
	{
		$this->__init();
		$sh = shell_exec("python ".$this->file." 2>&1");
		return empty($sh) ? "~" : $sh;
	}
}