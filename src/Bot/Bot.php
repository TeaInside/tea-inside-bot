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
		if (isset($this->input['message']['text'])) {
			$this->update_id = $this->input['update_id'];
			$this->name		 = $this->input['message']['from']['first_name'] . (isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : "");
			$this->username  = isset($this->input['message']['from']['username']) ? $this->input['message']['from']['username'] : null;
			$this->msgid     = $this->input['message']['message_id'];
			$this->date      = $this->input['message']['date'];
			$this->text      = $this->input['message']['text'];
			$this->lowertext = strtolower($this->input['message']['text']);
			$this->entities  = isset($this->input['message']['entities']) ? $this->input['message']['entities'] : [];
			$this->chat_id	 = $this->input['message']['chat']['id'];
			$this->chattitle = $this->input['message']['chat']['title'];
			$this->chattype  = $this->input['message']['chat']['type'];
			$this->is_bot    = $this->input['message']['from']['is_bot'];
			$this->user_id   = $this->input['message']['from']['id'];
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