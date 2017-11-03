<?php

namespace System\Handler;

use Exception;

class ExceptionHandler
{	

	/**
	 * @var \Exception
	 */
	private $ex;

	/**
	 * @param \Exception $exeption
	 */
	public function __construct(Exception $exception)
	{
		$this->ex = $exception;
	}
}