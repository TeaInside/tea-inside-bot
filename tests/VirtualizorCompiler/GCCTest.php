<?php

namespace VirtualizorCompiler;

use App\Virtualizor\Lang\GCC;
use PHPUnit\Framework\TestCase;

class GCCTest extends TestCase
{
    public function test1()
    {
        $code = "
#include<stdio.h>

int main()
{
	printf(\"hello world\");
}
		";
        $aa = new GCC($code);
        $this->assertTrue($aa->exec() == "hello world");
    }
}
