<?php

namespace App\Virtualizor\Lang;

use System\Contracts\App\Virtualizor\LangContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Ruby implements LangContract
{
	/**
	 * @var string
	 */
	private $rubyCode;

	/**
	 * @var string
	 */
	private $hash;

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor.
	 *
	 * @param string $rubyCode
	 */
	public function __construct($rubyCode)
	{
		$this->rubyCode = $rubyCode;
		$this->hash		= sha1($rubyCode);
		$this->file     = VIRTUALIZOR_DIR."/ruby/".$this->hash.".rb";
	}

	private function __init()
	{
		if (! is_dir(VIRTUALIZOR_DIR."/ruby")) {
			$exe = shell_exec("mkdir -p ".VIRTUALIZOR_DIR."/ruby");
			if (! is_dir(VIRTUALIZOR_DIR."/ruby")) {
				throw new \Exception($exe, 1);
			}
		}

		if (! file_exists($this->file)) {
			$handle = fopen($this->file, "w");
			fwrite($handle, $this->rubyCode);
			fclose($handle);
		}
	}

	public function exec()
	{
		$this->__init();
		$sh = shell_exec("ruby ".$this->file." 2>&1");
		return $sh == "" ? "~" : $sh;
	}
}