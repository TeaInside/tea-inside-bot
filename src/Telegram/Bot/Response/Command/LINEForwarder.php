<?php

namespace Telegram\Bot\Response\Command;

use Curl;
use Bridge;
use Telegram as B;
use Telegram\Bot\Bot;
use Telegram\Bot\Abstraction\CommandFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class LINEForwarder extends CommandFoundation
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

    public function run()
    {
        if ($this->b->msgtype === "text") {
            $__text = [];
            foreach (str_split($this->b->name."\n\n".$this->b->text, 1999) as $val) {
                $__text[] = [
                    "type" => "text",
                    "text" => $val
                ];
            }
            $data = [
                    "to" => "Ce20228a1f1f98e6cf9d6f6338603e962",
                    "messages" => $__text
                ];
        } elseif ($this->b->msgtype === "photo") {
            $url = $this->savePhoto();
            $__data[] = [
                "type" => "image",
                "originalContentUrl" => $url,
                "previewImageUrl" => $url
            ];
            if (!empty($this->b->text)) {
                foreach (str_split($this->b->name."\n\n".$this->b->text, 1999) as $val) {
                    $__data = [
                        "type" => "text",
                        "text" => $val
                    ];
                }
            }
            $data = [
                    "to" => "Ce20228a1f1f98e6cf9d6f6338603e962",
                    "messages" => $__data
                ];
        }
        print Bridge::go("line", ["\"".urlencode(json_encode($data))."\""]);
        return 1;
        return Bridge::go("line", ["\"".urlencode(json_encode($data))."\""], true);
    }

    private function savePhoto()
    {
        $p = end($this->b->photo);
        $a = json_decode(B::getFile([
            "file_id" => $p['file_id']
        ])['content'], true);
        $st = new Curl("https://api.telegram.org/file/bot".TOKEN."/".$a['result']['file_path']);
        file_put_contents(data."/line/tmp/".($t = time()).".jpg", $st->exec());
        return "https://webhook.crayner.cf/storage/data/line/tmp/".$t.".jpg";
    }
}
