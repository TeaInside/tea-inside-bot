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
         * Translate
         */
        $this->route(function () {
            return
                CMDUtil::fW($trcmd, "/translate") ||
                CMDUtil::fW($trcmd, "!translate") ||
                CMDUtil::fW($trcmd, "~translate") ||
                CMDUtil::fW($trcmd, "/tl")        ||
                CMDUtil::fW($trcmd, "!tl")        ||
                CMDUtil::fW($trcmd, "~tl");
        }, "\\Handler\\Response\\NormalMessage\\Command\\Translate");

        /**
         * Translate replied message.
         */
        $this->route(function () {
            return
                CMDUtil::fW($trcmd, "/tlr")    ||
                CMDUtil::fW($trcmd, "!tlr")    ||
                CMDUtil::fW($trcmd, "~tlr");
        }, "\\Handler\\Response\\NormalMessage\\Command\\TranslateRepliedMessage");

        /**
         * Admin list.
         */
        $this->route(function () {
            return
                CMDUtil::fW($trcmd, "/admin")  ||
                CMDUtil::fW($trcmd, "!admin")  ||
                CMDUtil::fW($trcmd, "~admin");
        }, "\\Handler\\Response\\NormalMessage\\Command\\Admin");

        /**
         * Start bot.
         */
        $this->route(function () {
            return
                $this->h->lowerText === "/start";
        }, "\\Handler\\Response\\NormalMessage\\Command\\Start");
        
        /**
         * Ping bot.
         */
        $this->route(function () {
            return
                CMDUtil::fW($trcmd, "/ping")   ||
                CMDUtil::fW($trcmd, "!ping")   ||
                CMDUtil::fW($trcmd, "~ping");
        }, function () {
            B::sendMessage(
                [
                    "chat_id" => $this->h->chat_id,
                    "text" => (time() - ($this->h->time))." s",
                    "reply_to_message_id" => $this->h->msgid
                ]
            );
        });

        $this->route(function() {
            return
                CMDUtil::fW($trcmd, "/sh")       ||
                CMDUtil::fW($trcmd, "!sh")       ||
                CMDUtil::fW($trcmd, "~sh")       ||
                CMDUtil::fW($trcmd, "shexec")    ||
                CMDUtil::fW($trcmd, "/shexec")   ||
                CMDUtil::fW($trcmd, "!shexec")   ||
                CMDUtil::fW($trcmd, "~shexec");
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
