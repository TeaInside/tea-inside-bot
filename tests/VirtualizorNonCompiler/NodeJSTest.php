<?php

namespace VirtualizorNonCompiler;

use App\Virtualizor\Lang\NodeJS;
use PHPUnit\Framework\TestCase;

class NodeJSTest extends TestCase
{
    public function test1()
    {
        $code = " console.log(\"hello world\");";
        $aa = new NodeJS($code);
        $this->assertTrue(trim($aa->exec()) == "hello world");
    }
}
