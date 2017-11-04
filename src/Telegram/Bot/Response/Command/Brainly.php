<?php

namespace Telegram\Bot\Response\Command;

use DB;
use PDO;
use Telegram\Lang;
use Telegram\Bot\Bot;
use Telegram as B;
use Plugins\Brainly\Brainly as BrainlyPlugin;
use Telegram\Bot\Abstraction\CommandFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class AdminHammer extends CommandFoundation
{
    

    /**
     * @var \Bot\Bot
     */
    private $b;

    /**
     * Constructor.
     *
     * @param \Bot\Bot $bot
     */
    public function __construct(Bot $bot)
    {
        $this->b = $bot;
    }

    public function ask()
    {
        $st = explode(" ", $this->b->lowertext, 2);
        if (isset($st[1])) {
            $st = new BrainlyPlugin(
                    trim($st[1])
                );
            $st->limit(10);
            $st = $st->exec(); $r = ""; $i = 1;
            $ll = function ($str) {
                return trim(strip_tags(
                            html_entity_decode(
                                str_replace("<br />", "\n", $str),
                                ENT_QUOTES,
                                "UTF-8"
                            )
                        )
                    );
            };
            foreach ($st as $val) {
                $r .=  ($i++).". ".$ll($val['content'])."\nJawaban : "."\n".
                    $ll($val['responses'][0]['content'])."\n\n";
            }
            $r = trim($r);
            B::sendMessage(
                [
                    "chat_id" => $this->b->chat_id,
                    "reply_to_message_id" => $this->b->msgid,
                    "text" => $r
                ]
            );
        }
    }
}
