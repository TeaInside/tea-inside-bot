<?php

namespace VirtualizorCompiler;

use App\Virtualizor\Lang\Java;
use PHPUnit\Framework\TestCase;

class JavaTest extends TestCase
{
    public function test1()
    {
        $code = "
import java.*;
public class test
{
	public static void main(String[] argv)
	{
		System.out.print(\"hello world\");
	}
}
		";
        $aa = new Java($code);
        $this->assertTrue($aa->exec() == "hello world");
    }
}
