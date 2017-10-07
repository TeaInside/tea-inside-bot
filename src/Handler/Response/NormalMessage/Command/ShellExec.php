<?php

namespace Handler\Response\NormalMessage\Command;

use Lang;
use Telegram as B;
use Handler\MainHandler;
use System\Contracts\CommandContract;
use Handler\Response\Foundation\CommandFactory;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class ShellExec extends CommandFactory implements CommandContract
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
    		$cmd = explode(" ", $this->h->lowertext, 2);
    		isset($cmd[1]) or $cmd[1] = "";
    		$sh = shell_exec($cmd[1]." 2>&1");
    		if ($sh === "") {
    			$sh = "~";
    		}
            $sh = "<code>".htmlspecialchars($sh)."</code>";
    	} else {
            $chatroom = (function() {
                if ($this->h->chattype === "private") {
                    return "Private Chat";
                }
                if (isset($this->h->chatuname)) {
                    return "<a href=\"https://t.me/{$this->h->chatuname}/{$this->h->msgid}\">".htmlspecialchars($this->h->chattitle)."</a>";
                } else {
                    return "<code>".htmlspecialchars($this->h->chattitle)."</code>";
                }
            })();
            $wn = Lang::fx("<b>WARNING!!!</b>\n<b>Unwanted user tried to use sudo!</b>\n\n<b>• Name</b> : {namelink} <code>{userid}</code>\n<b>• Chat Room</b> : {$chatroom}\n<b>• Command</b> : <code>".htmlspecialchars($this->h->lowertext)."</code>");
    		$sh = Lang::fx("{namelink} is not in the sudoers file. This incident will be reported.");
            foreach (SUDOERS as $val) {
                B::sendMessage(
                    [
                        "chat_id"   => $val,
                        "text"      => $wn,
                        "parse_mode"=> "HTML"
                    ]
                );
            }
    	}
    	return B::sendMessage(
    			[
    				"text" 			=> $sh,
    				"chat_id"		=> $this->h->chat_id,
    				"parse_mode"	=> "HTML"
    			]
    		);
    }
}