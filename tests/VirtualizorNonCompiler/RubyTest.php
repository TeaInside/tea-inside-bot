<?php

namespace VirtualizorNonCompiler;

use App\Virtualizor\Lang\Ruby;
use PHPUnit\Framework\TestCase;

class RubyTest extends TestCase
{
	public function test1()
	{
		$code = "puts \"hello world\";";
		$aa = new Ruby($code);
		$this->assertTrue(trim($aa->exec()) == "hello world");
	}
}
