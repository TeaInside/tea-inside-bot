<?php

namespace Plugins\Virtualizor\Lang;

use Curl;
use Plugins\Virtualizor\Interpreter;
use Contracts\Plugins\Virtualizor\Executable;

final class PHP extends Interpreter implements Executable
{
    

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Constructor.
     *
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
        $this->hash = sha1($code);
    }

    public function init()
    {
        if (! defined("VIRTUALIZOR_DIR")) {
            $this->errorMessage = "VIRTUALIZOR_DIR is not defined yet!";
            return false;
        }

        if (! defined("VIRTUALIZOR_URL")) {
            $this->errorMessage = "VIRTUALIZOR_URL is not defined yet!";
            return false;
        }

        is_dir(VIRTUALIZOR_DIR) or shell_exec("mkdir -p ".VIRTUALIZOR_DIR);

        if (! is_dir(VIRTUALIZOR_DIR)) {
            $this->errorMessage = "Cannot create directory ".VIRTUALIZOR_DIR;
            return false;
        }

        if (! file_exists(VIRTUALIZOR_DIR."/".$this->hash.".php")) {
            $handle = fopen(VIRTUALIZOR_DIR."/".$this->hash.".php", "w");
            fwrite($handle, $this->code);
            fclose($handle);
            if (! file_exists(VIRTUALIZOR_DIR."/".$this->hash.".php")) {
                $this->errorMessage = "Cannot create file ".VIRTUALIZOR_DIR."/".$this->hash.".php";
                return false;
            }
        }
        return true;
    }

    public function exec()
    {
        $st = new Curl(VIRTUALIZOR_URL."/".$this->hash.".php");
        $st->set_opt(
            [
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_CONNECTTIMEOUT => 5
            ]
        );
        $out = $st->exec();
        $err = $st->error and $out = $err;
        return $out;
    }

    public function errorInfo()
    {
        return $this->errorMessage;
    }
}