<?php

use System\Hub\Singleton;

final class Lang
{
	use Singleton;

	/**
	 * @var string
	 */
	private $lang;

	/**
	 * Constructor.
	 *
	 * @param string $lang
	 */
	public function __construct($lang)
	{
		$this->lang = $lang;
	}

	/**
	 * @param string $lang
	 * @return bool
	 */
	public static function init($lang)
	{
		self::getInstance($lang);
		return true;
	}

	public static function get($space)
	{

	}
}