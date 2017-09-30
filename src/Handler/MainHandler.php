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
	public $chat_id;

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
			$this->chattype = "text";
			$this->text		= $this->input['message']['text'];
			$this->chat_id	= (string) $this->input['message']['chat']['id'];
		}
	}

	private function response()
	{
		B::sendMessage(
			[
				"chat_id" => $this->chat_id,
				"text"    => "Hello World!",
			]
		);
	}
}