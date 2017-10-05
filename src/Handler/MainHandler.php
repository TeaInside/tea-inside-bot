<?php

namespace Handler;

use Lang;
use Telegram as B;
use Handler\Response;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class MainHandler
{
    /**
     * @var array|null
     */
    public $replyto;

    /**
     * @var string
     */
    public $chattitle;

    /**
     * @var string
     */
    public $msgtype;

    /**
     * @var string
     */
    public $chattype;

    /**
     * @var string
     */
    public $text;
    
    /**
     * @var string
     */
    public $lowertext;

    /**
     * @var string
     */
    public $chat_id;

    /**
     * @var string
     */
    public $msgId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $username;

    /**
     * Constructor.
     * @param string $input
     */
    public function __construct($input)
    {
        if ($input) {
            $this->input = json_decode($input, true);
        } else {
            $this->input = json_decode(file_get_contents("php://input"), true);
        }
    }

    /**
     * Run app.
     */
    public function run()
    {
        $this->parseEvent();
        $this->response();
    }

    /**
     * Parse Webhook Event.
     */
    private function parseEvent()
    {
        isset($this->input['reply_to_message']) and $this->replyto = $this->input['reply_to_message'];
        isset($this->input['message']['chat']['title']) and $this->chattitle = $this->input['message']['chat']['title'];
        isset($this->input['message']['chat']['username']) and $this->chatuname = $this->input['message']['chat']['username'];
        if (isset($this->input['message']['text'])) {
            $this->msgtype    = "text";
            $this->chattype   = $this->input['message']['chat']['type'];
            $this->text          = $this->input['message']['text'];
            $this->lowertext  = strtolower($this->text);
            $this->chat_id      = (string) $this->input['message']['chat']['id'];
            $this->msgid      = (string) $this->input['message']['message_id'];
            $this->name          = $this->input['message']['from']['first_name'] . (isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : "");
            $this->first_name = $this->input['message']['from']['first_name'];
            $this->last_name  = isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : null;
            $this->userId      = $this->input['message']['from']['id'];
            $this->username   = isset($this->input['message']['from']['username']) ? $this->input['message']['from']['username'] : null;
        }
    }

    /**
     * Response.
     */
    private function response()
    {
        if (in_array($this->msgType, ["text"])) {
            $res = new Response($this);
            $res();
        }
    }

    public function __get($var)
    {
        return $this->{strtolower($var)};
    }
}
