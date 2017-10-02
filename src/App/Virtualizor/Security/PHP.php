<?php

namespace App\Virtualizor\Security;

use System\Contracts\App\Virtualizor\SecurityContract;

class PHP implements SecurityContract
{	
	/**
	 * @var string
	 */
	private $phpCode;

	/**
	 * @var int
	 */
	private $restrictedToken = 0;

	/**
	 * @var string
	 */

	/**
	 * Constructor.
	 * @param string $code
	 */
	public function __construct($phpCode)
	{
		$this->phpCode = $phpCode;
	}

	private function parsePHPCode()
	{

	}

	public function is_secure()
	{
		$this->parsePHPCode();
		return $this->restrictedToken === 0;
	}
}

