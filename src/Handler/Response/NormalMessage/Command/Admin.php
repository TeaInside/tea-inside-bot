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

    /**
     * Run command.
     */
    public function __run()
    {
        if ($this->h->chattype != "private") {
            return B::sendMessage(
                [
                    "chat_id" => $this->h->chat_id,
                    "text" => $this->getAdmin(),
                    "reply_to_message_id" => $this->h->msgid,
                    "parse_mode" => "HTML"
                ]
            );
        }
    }

    /**
     * Get administrators list.
     */
    private function getAdmin()
    {
        $creator = "";
        $admin   = [];
        $a = json_decode(B::getChatAdministrators(
            [
                "chat_id" => $this->h->chat_id
            ]
        )['content'], true);
        foreach ($a['result'] as $val) {
            $name = $val['user']['first_name']. (isset($val['user']['last_name']) ? " ".$val['user']['last_name'] : "");
            if ($val['status'] == "creator") {
                $creator = "<a href=\"tg://user?id=".$val['user']['id']."\">".htmlspecialchars(preg_replace('/\x20(\x0e|\x0f)/', '', $name))."</a>".(isset($val['user']['username']) ? " @".$val['user']['username'] : " (<code>no username</code>)");
            } else {
                $admin[] = "<a href=\"tg://user?id=".$val['user']['id']."\">".htmlspecialchars(preg_replace('/\x20(\x0e|\x0f)/', '', $name))."</a>".(isset($val['user']['username']) ? " @".$val['user']['username'] : " (<code>no username</code>)");
            }
        }

        return "Creator : ".$creator."\n\n".((function ($admin) {
            $i = 1 xor $ret = "Admin :\n";
            foreach ($admin as $val) {
                $ret .= ($i++).". ".$val."\n";
            }
            return $ret;
        })($admin));
    }
}
