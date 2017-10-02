<?php

namespace App\Virtualizor\Lang;

use App\Virtualizor\Compiler;
use System\Contracts\App\Virtualizor\LangContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class CPP extends Compiler implements LangContract
{
    /**
     * @var string
     */
    private $cppCode;

    /**
     * @var string
     */
    private $hash;

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
     * @param string $cppCode
     */
    public function __construct($cppCode)
    {
        $this->cppCode    = $cppCode;
        $this->hash    = sha1($cppCode);
        $this->file    = VIRTUALIZOR_DIR."/cpp/".$this->hash.".cpp";
    }

    /**
     * Compile it.
     */
    private function __compile()
    {
        $check = shell_exec("g++ --version || echo 0");
        if ($check === 0) {
            $this->errorInfo = "G++ not installed!";
            return false;
        }
        $compile = shell_exec("g++ ".$this->file." -o ".VIRTUALIZOR_DIR."/cpp/".$this->hash." 2>&1");
        if ($compile) {
            $this->errorInfo = $compile;
            return false;
        }
        return true;
    }

    /**
     * Init file.
     */
    private function __init()
    {
        if (! is_dir(VIRTUALIZOR_DIR."/cpp")) {
            $exe = shell_exec("mkdir -p ".VIRTUALIZOR_DIR."/cpp");
            if (! is_dir(VIRTUALIZOR_DIR."/cpp")) {
                throw new \Exception($exe, 1);
            }
        }
        if (! file_exists($this->file)) {
            $handle = fopen($this->file, "w");
            fwrite($handle, $this->cppCode);
            fclose($handle);
        }
        if (file_exists($this->file)) {
            return true;
        } else {
            $this->errorInfo = "Cannot create file.";
            return false;
        }
    }

    /**
     * Run.
     */
    private function __exec()
    {
        $exec = shell_exec(VIRTUALIZOR_DIR."/cpp/".$this->hash);
        if ($exec) {
            return $exec;
        } else {
            return "~";
        }
    }

    /**
     * Executor.
     */
    public function exec()
    {
        if ($this->__init()) {
            $this->__compile();
            if (! $this->errorInfo) {
                return $this->__exec();
            } else {
                return $this->errorInfo;
            }
        } else {
            return $this->errorInfo;
        }
    }
}
