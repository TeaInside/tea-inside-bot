<?php

namespace Handler;

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
	public $msgType;

	/**
	 * @var string
	 */
	public $chatType;

	/**
	 * @var string
	 */
	public $text;
	
	/**
	 * @var string
	 */
	public $lowerText;

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
			$this->msgType    = "text";
			$this->chatType   = $this->input['message']['chat']['type'];
			$this->text		  = $this->input['message']['text'];
			$this->lowerText  = strtolower($this->text);
			$this->chat_id	  = (string) $this->input['message']['chat']['id'];
			$this->msgId	  = (string) $this->input['message']['message_id'];
			$this->name		  = $this->input['message']['from']['first_name'] . (isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : "");
			$this->first_name = $this->input['message']['from']['first_name'];
			$this->last_name  = isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : null;
		}
	}

	/**
	 * Response.
	 */
	private function response()
	{
		if (in_array($this->msgType, ["text"])) {
			var_dump(123);
			$res = new Response($this);
			$res();
		}
	}
}