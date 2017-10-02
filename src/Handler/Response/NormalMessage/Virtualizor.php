<?php

namespace Handler\Response;

use App\Virtualizor\Lang\PHP;
use App\Virtualizor\Security\PHP as PHPSecurity;

class Virtualizor
{
	/** 
	 * @var string
	 */
	private $text;

	/**
	 * @var string
	 */
	private $absText;

	/**
	 * @var bool
	 */
	private $sudo;

	/**
	 * Constructor.
	 * @param string $lowerText
	 * @param string $absText
	 */
	public function __construct($lowerText, $absText, $sudo = false)
	{
		$this->lowerText    = strtolower($lowerText);
		$this->absText 		= $absText;
		$this->sudo 		= $sudo;
	}

	/**
	 * Exec.
	 */
	public function exec()
	{
		if (substr($this->lowerText, 0, 5) == "<?php") {

		}
	}

	private function is_secure($par = null)
	{
		if ($this->sudo) {
			return true;
		}
		switch ($par) {
			case 'php':
				$st = new PHPSecurity($this->absText);
				break;
			default:
				return false;
				break;
		}
		return $st->is_secure();
	}
}