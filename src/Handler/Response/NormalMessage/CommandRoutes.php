<?php

namespace Handler\Response\NormalMessage;

use Lang;
use Closure;
use Telegram as B;
use Handler\MainHandler;
use Handler\Response\NormalMessage\CommandUtils as CMDUtil;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class CommandRoutes
{
    /**
     * @var Handler\MainHandler
     */
    private $h;

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var object
     */
    public $run;

    /**
     * Constructor.
     *
     * @param Handler\MainHandler
     */
    public function __construct(MainHandler $handler)
    {
        $this->h = $handler;
    }

    /**
     * Init command routes.
     */
    private function init_routes()
    {
        Lang::init("id");
        Lang::initMainHandler($this->h);
        
        /**
         * Ping bot.
         */
        $this->route(function () {
            return
                CMDUtil::fW($this->h->lowertext, "/ping")   ||
                CMDUtil::fW($this->h->lowertext, "!ping")   ||
                CMDUtil::fW($this->h->lowertext, "~ping");
        }, function () {
            B::sendMessage(
                [
                    "chat_id" => $this->h->chat_id,
                    "text" => (time() - ($this->h->time))." s",
                    "reply_to_message_id" => $this->h->msgid
                ]
            );
        });

        /**
         * Translate
         */
        $this->route(function () {
            return
                CMDUtil::fW($this->h->lowertext, "/translate") ||
                CMDUtil::fW($this->h->lowertext, "!translate") ||
                CMDUtil::fW($this->h->lowertext, "~translate") ||
                CMDUtil::fW($this->h->lowertext, "/tl")        ||
                CMDUtil::fW($this->h->lowertext, "!tl")        ||
                CMDUtil::fW($this->h->lowertext, "~tl");
        }, "\\Handler\\Response\\NormalMessage\\Command\\Translate");

        /**
         * Translate replied message.
         */
        $this->route(function () {
            return
                CMDUtil::fW($this->h->lowertext, "/tlr")    ||
                CMDUtil::fW($this->h->lowertext, "!tlr")    ||
                CMDUtil::fW($this->h->lowertext, "~tlr");
        }, "\\Handler\\Response\\NormalMessage\\Command\\TranslateRepliedMessage");

        /**
         * Admin list.
         */
        $this->route(function () {
            return
                CMDUtil::fW($this->h->lowertext, "/admin")  ||
                CMDUtil::fW($this->h->lowertext, "!admin")  ||
                CMDUtil::fW($this->h->lowertext, "~admin");
        }, "\\Handler\\Response\\NormalMessage\\Command\\Admin");

        /**
         * Start bot.
         */
        $this->route(function () {
            return
                $this->h->lowerText === "/start";
        }, "\\Handler\\Response\\NormalMessage\\Command\\Start");

        /**
         * Shell exec
         */
        $this->route(function() {
            return
                CMDUtil::fW($this->h->lowertext, "/sh")       ||
                CMDUtil::fW($this->h->lowertext, "!sh")       ||
                CMDUtil::fW($this->h->lowertext, "~sh")       ||
                CMDUtil::fW($this->h->lowertext, "shexec")    ||
                CMDUtil::fW($this->h->lowertext, "/shexec")   ||
                CMDUtil::fW($this->h->lowertext, "!shexec")   ||
                CMDUtil::fW($this->h->lowertext, "~shexec");
        }, "\\Handler\\Response\\NormalMessage\\Command\\ShellExec");

        /**
         * Debug
         */
        $this->route(function() {
            return
                CMDUtil::fW($this->h->lowertext, "/d")       ||
                CMDUtil::fW($this->h->lowertext, "!d")       ||
                CMDUtil::fW($this->h->lowertext, "~d")       ||
                (   CMDUtil::fW($this->h->lowertext, "debug") &&
                            count(explode(" ", $this->h->lowertext)) === 1) ||
                CMDUtil::fW($this->h->lowertext, "/debug")   ||
                CMDUtil::fW($this->h->lowertext, "!debug")   ||
                CMDUtil::fW($this->h->lowertext, "~debug");
        }, "\\Handler\\Response\\NormalMessage\\Command\\ShellExec");

        return isset($this->run);
    }

    /**
     * Set route.
     *
     * @param \Closure          $cond
     * @param string|\Closure   $route
     */
    private function route(Closure $cond, $route)
    {
        if (isset($this->run)) {
            return false;
        }
        if (((bool) $cond())) {
            $this->run = $route;
            return true;
        }
        return false;
    }

    /**
     * Check route.
     */
    public function needResponse()
    {
        return $this->init_routes();
    }
}
