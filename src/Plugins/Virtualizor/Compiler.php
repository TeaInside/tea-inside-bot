<?php

namespace Plugins\Virtualizor;

use Exception;

/**
 * Compiler parent.
 */
abstract class Compiler
{
	/**
	 * Constructor.
	 *
	 * @param string $code
	 */
	abstract public function __construct($code);

	/**
	 *
	 *
	 */
	private function compile()
	{
	}
}