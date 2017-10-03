<?php

namespace VirtualizorNonCompiler;

use App\Virtualizor\Lang\Python;
use PHPUnit\Framework\TestCase;

class PythonTest extends TestCase
{
    public function test1()
    {
        $code = "print(\"hello world\");";
        $aa = new Python($code);
        $this->assertTrue(trim($aa->exec()) == "hello world");
    }
}
