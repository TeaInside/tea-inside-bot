<?php

namespace App\Virtualizor\Lang;

use System\Contracts\App\Virtualizor\LangContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class NodeJS implements LangContract
{
    /**
     * @var string
     */
    private $jsCode;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $file;

    /**
     * Constructor.
     *
     * @param string $jsCode
     */
    public function __construct($jsCode)
    {
        $this->jsCode = $jsCode;
        $this->hash   = sha1($jsCode);
        $this->file   = VIRTUALIZOR_DIR."/nodejs/".$this->hash.".js";
    }

    private function __init()
    {
        if (! is_dir(VIRTUALIZOR_DIR."/nodejs")) {
            $mkdir = shell_exec("mkdir -p ".VIRTUALIZOR_DIR."/nodejs");
            if (!is_dir(VIRTUALIZOR_DIR."/nodejs")) {
                throw new \Exception($mkdir, 1);
            }
        }

        if (! file_exists($this->file)) {
            $handle = fopen($this->file, "w");
            fwrite($handle, $this->jsCode);
            fclose($handle);
        }
    }

    public function exec()
    {
        $this->__init();
        $sh = shell_exec("node ".$this->file." 2>&1");
        return $sh == "" ? "~" : $sh;
    }
}
