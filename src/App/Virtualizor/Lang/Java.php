<?php

namespace App\Virtualizor\Lang;

use App\Virtualizor\Compiler;
use System\Contracts\App\Virtualizor\LangContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Java extends Compiler implements LangContract
{
	/**
	 * @var string
	 */
	private $javaCode;

	/**
	 * @var string
	 */
	private $className;

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor.
	 *
	 * @param string $javaCode
	 */
	public function __construct($javaCode)
	{
		$this->javaCode  = $javaCode;
		$this->getClassName();
	}
}