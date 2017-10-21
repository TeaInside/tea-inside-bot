<?php

namespace Bot;

use Bot\Response;
use Telegram as B;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class Bot
{

	/**
	 * @var array
	 */
	private $input = [];

	/**
	 * Constructor.
	 *
	 * @param string $input
	 */
	public function __construct($input)
	{
		$this->input = json_decode($input, true);
	}

	/**
	 * Parse webhook event.
	 *
	 */
	private function parseEvent()
	{
		$input = $this->input;
		if (isset($this->input['message']['text'])) {
			$this->update_id = $this->input['update_id'];
			$this->name		 = $input['message']['from']['first_name'] . (isset($input['message']['from']['last_name']) ? " ".$input['message']['from']['last_name'] : "");
			$this->username  = isset($input['message']['from']['username']) ? $input['message']['from']['username'] : null;
			$this->msgid     = $input['message']['message_id'];
			$this->date      = $input['message']['date'];
			$this->text      = $input['message']['text'];
			$this->lowertext = strtolower($input['message']['text']);
			$this->entities  = isset($input['message']['entities']) ? $input['message']['entities'] : [];
			$this->chat_id	 = $input['message']['chat']['id'];
			$this->chattitle = $input['message']['chat']['title'];
			$this->chattype  = $input['message']['chat']['type'];
			$this->is_bot    = $input['message']['from']['is_bot'];
			$this->user_id   = $input['message']['from']['id'];
		}
	}

	/**
	 * Response.
	 *
	 */
	private function response()
	{
		$st = new Response($this);
		return $st->run();
	}

	/**
	 * Run bot.
	 *
	 */
	public function run()
	{
		$this->parseEvent();
		return $this->response();
	}
}