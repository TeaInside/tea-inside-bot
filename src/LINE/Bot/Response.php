<?php

namespace LINE\Bot;

use LINE;
use Bridge;
use LINE\Bot\Bot;
use LINE\Bot\Response\Command;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
class Response
{

    /**
     * @var \LINE\Bot\Bot
     */
    private $b;

    /**
     * Constructor.
     *
     * @param \LINE\Bot\Bot $bot
     */
    public function __construct(Bot $bot)
    {
        $this->b = $bot;
    }

    public function run()
    {
        $this->sendToTelegram();
        $st = new Command($this->b);
        $st->run();
    }

    private function sendToTelegram()
    {
        if ($this->b->msgtype === "text") {
            $u = json_decode(LINE::profile($this->b->userid)['content'], true);
            isset($u['displayName']) or $u['displayName'] = $this->b->userid;
            $msg = "<b>".htmlspecialchars($u['displayName'])."</b>\n<pre>".htmlspecialchars($this->b->text)."</pre>";
            Bridge::go(
                "telegram/action_cli.php", ["sendMessage", urlencode(
                    json_encode(
                        [
                        "text" => $msg,
                        "chat_id" => -1001134449138,
                        "parse_mode" => "HTML"
                        ]
                    )
                )]
            );
        } elseif ($this->b->msgtype === "photo") {
            is_dir(data."/line") or mkdir(data."/line");
            is_dir(data."/line/tmp") or mkdir(data."/line/tmp");
            file_put_contents(data."/line/tmp/".($t = time()).".jpg", LINE::getContent($this->b->msgid)['content']);
            $u = json_decode(LINE::profile($this->b->userid)['content'], true);
            isset($u['displayName']) or $u['displayName'] = $this->b->userid;
            $msg = htmlspecialchars($u['displayName']);
            Bridge::go(
                "telegram/action_cli.php", ["sendPhoto", urlencode(
                    json_encode(
                        [
                        "caption" => $msg,
                        "photo" => "https://webhook.crayner.cf/storage/data/line/tmp/".$t.".jpg",
                        "chat_id" => -1001134449138,
                        "parse_mode" => "HTML"
                        ]
                    )
                )]
            );
        }
    }
}
