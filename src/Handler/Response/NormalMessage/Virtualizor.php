<?php

namespace Handler\Response;

use App\Virtualizor\Lang\PHP;

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
	 * Constructor.
	 * @param string $lowerText
	 * @param string $absText
	 */
	public function __construct($lowerText, $absText)
	{
		$this->lowerText    = strtolower($lowerText);
		$this->absText 		= $absText;
	}

	/**
	 * Exec.
	 */
	public function exec()
	{
		if (substr($this->lowerText, 0, 5) == "<?php") {
			
		}
	}
}