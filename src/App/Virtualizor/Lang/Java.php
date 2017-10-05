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
     * @var string
     */
    private $errorInfo;

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

    /**
     * Get java class name.
     */
    private function getClassName()
    {
        $a = explode("class ", $this->javaCode, 2);
        if (! isset($a[1])) {
            return false;
        }
        $a = explode("{", $a[1], 2);
        if (! isset($a[1])) {
            return false;
        }
        $this->className = trim($a[0]);
        $this->file      = VIRTUALIZOR_DIR."/java/".$this->className.".java";
    }

    /**
     * Init java file.
     */
    private function __init()
    {
        if (! is_dir(VIRTUALIZOR_DIR."/java")) {
            $exe = shell_exec("mkdir -p ".VIRTUALIZOR_DIR."/java");
            if (! is_dir(VIRTUALIZOR_DIR."/java")) {
                throw new \Exception($exe, 1);
            }
        }

        $handle = fopen($this->file, "w");
        fwrite($handle, $this->javaCode);
        fclose($handle);
    }

    /**
     * Compile it.
     */
    private function __compile()
    {
        $comp = shell_exec("javac ".$this->file." 2>&1");
        if ($comp) {
            $this->errorInfo = trim($comp);
        }
    }

    /**
     * Private exec.
     */
    private function __exec()
    {
        $out = shell_exec("cd ".VIRTUALIZOR_DIR."/java && java ".$this->className." 2>&1");
        return $out === "" ? "~" : $out;
    }

    /**
     * Exec.
     */
    public function exec()
    {
        $this->__init();
        if (! ($out = $this->__compile())) {
            $out = $this->__exec();
        }
        return $out;
    }
}
