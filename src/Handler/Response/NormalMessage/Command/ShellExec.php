<?php

namespace Handler\Response\NormalMessage\Command;

use Lang;
use Telegram as B;
use Handler\MainHandler;
use System\Contract\CommandContract;
use Handler\Response\Foundation\CommandFactory;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Admin extends CommandFactory implements CommandContract
{
    /**
     * @var Handler\MainHandler
     */
    private $h;

    /**
     * Constructor.
     *
     * @param Handler\MainHandler $handler
     */
    public function __construct(MainHandler $handler)
    {
        $this->h = $handler;
    }

    private function is_secure()
    {
    	if (in_array($this->h->userid, SUDOERS)) {
    		return true;
    	}
    	return ! (strpos($this->h->lowertext, "sudo") !== false);
    }

    /**
     * Run command.
     */
    public function __run()
    {
    	if ($this->is_secure()) {
    		$cmd = explode(" ", $this->lowertext, 2);
    		isset($cmd[1]) or $cmd[1] = "";
    		$sh = shell_exec($cmd[1]." 2>&1");
    		if ($sh === "") {
    			$sh = "~";
    		}
    	} else {
    		$sh = "Error!";
    	}
    	return B::sendMessage(
    			[
    				"text" 			=> "<code>".htmlspecialchars($sh)."</code>",
    				"chat_id"		=> $this->h->chat_id,
    				"parse_mode"	=> "HTML"
    			]
    		);
    }
}