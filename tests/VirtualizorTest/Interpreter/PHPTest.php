<?php

namespace VirtualizorTest\Interpreter\PHPTest;

use Plugins\Virtualizor\Bridge;
use PHPUnit\Framework\TestCase;

class PHPTest extends TestCase
{

	/**
	 * @var \Plugin\Virtualizor\Bridge
	 */
	private $instance;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->instance = new Bridge(
			"<?php print \"Hello World!\";"
			, "php"
		);
	}

	public function testInit()
	{
		$this->assertTrue($this->instance->init());
	}
}
