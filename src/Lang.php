<?php

use Lang\Map;
use Handler\MainHandler;
use System\Hub\Singleton;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class Lang
{
    use Singleton;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var Handler\MainHandler
     */
    private $h;

    /**
     * Constructor.
     * @param string $lang
     */
    public function __construct($lang)
    {
        if (isset(Map::$lang[$lang])) {
            $this->lang = Map::$lang[$lang];
        } else {
            throw new LanguageNotFoundException("Language '{$lang}' not found!", 101);
        }
    }
    
    public static function init($lang)
    {
        self::$instance = new self($lang);
    }

    public static function initMainHandler(MainHandler $handler)
    {
        self::getInstance()->h = $handler;
    }

    public static function fx($fx)
    {
        $ins = self::getInstance();
        if ($ins->h instanceof MainHandler) {
            return str_replace(
                [
                "{namelink}",
                "{userid}",
                "{msgid}",
                "{username}",
                "{name}"
                ],
                [
                "<a href=\"tg://user?id=".$ins->h->userid."\">".htmlspecialchars($ins->h->name)."</a>",
                $ins->h->userid,
                $ins->h->msgid,
                $ins->h->username,
                $ins->h->name
                ],
                $fx
            );
        }
        return $fx;
    }

    public static function system($gt)
    {
        return self::fx((self::getInstance()->lang."System")::$sys[$gt]);
    }
}
