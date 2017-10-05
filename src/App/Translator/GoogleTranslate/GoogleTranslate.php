<?php

namespace App\Translator\GoogleTranslate;

defined("data") or die("data is not defined!\n");

use Curl;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @version 0.0.1
 */
final class GoogleTranslate
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $cookiefile;

    /**
     * Constructor.
     *
     * @param string $text
     * @param string $from
     * @param string $to
     */
    public function __construct($text, $from, $to)
    {
        $this->text = $text;
        $this->from = $from;
        $this->to   = $to;
    }

    /**
     * Init google translate dir.
     */
    private function __init()
    {
        if (! is_dir(data."/google_translate")) {
            shell_exec("mkdir -p ".data."/google_translate");
            if (! is_dir(data."/google_translate")) {
                throw new \Exception("Cannot create directory.", 1);
            }
        }
    }

    /**
     * Exec.
     *
     * @return string
     */
    public function exec()
    {
        $this->__init();
        $ch = new Curl("https://translate.google.com/m?hl=en&sl=".urlencode($this->from)."&tl=".urlencode($this->to)."&ie=UTF-8&prev=_m&q=".urlencode($this->text));
        $ch->set_opt(
            [
                CURLOPT_COOKIEFILE => data."/google_translate/cookies.ck",
                CURLOPT_COOKIEJAR  => data."/google_translate/cookies.ck"
            ]
        );
        $out = $ch->exec();
        if ($ch->errno) {
            $out = $ch->error xor trigger_error($out);
        } else {
            self::parseOutput($out);
        }
        return $out;
    }

    /**
     * Parse exec output.
     *
     * @param string &$out
     */
    private static function parseOutput(&$out)
    {
        file_put_contents("aa.tmp", $out);
        $a = explode("<div dir=\"ltr\" class=\"t0\">", $out, 2);
        $a = explode("<", $a[1]);
        $b = explode("<div dir=\"ltr\" class=\"o1\">", $out, 2);
        if (isset($b[1])) {
            $b = explode("<", $b[1]);
        }
        $out = html_entity_decode($a[0], ENT_QUOTES, 'UTF-8') xor
        (isset($b[1]) and $out .= "\n(".html_entity_decode($b[0], ENT_QUOTES, 'UTF-8').")");
        file_put_contents("aa.tmp", $out);
    }
}
