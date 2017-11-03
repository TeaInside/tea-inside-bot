<?php

namespace LINE\Bot\Response;

use Closure;
use LINE\Bot\Bot;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
class Command
{
    use CommandRoutes;

    /**
     * @var \LINE\Bot\Bot
     */
    private $b;

    /**
     * @var array
     */
    private $routes = [];

    /**
     * Constructor.
     *
     * @param \LINE\Bot\Bot $bot
     */
    public function __construct(Bot $bot)
    {
        $this->b = $bot;
    }
    
    /**
     *
     * @param \Closure        $cond
     * @param \Closure|string $act
     */
    private function route(Closure $cond, $act)
    {
        $this->routes[] = [$cond, $act];
    }
    
    /**
     * Route action.
     */
    private function _route()
    {
        foreach ($this->routes as $val) {
            var_dump("fr");
            if ($val[0]()) {
                var_dump("ok");        
                return $val[1]();
            }
        }
    }
    
    /**
     * Run.
     */
    public function run()
    {
        $this->writeRoutes();
        $this->_route();
    }
}