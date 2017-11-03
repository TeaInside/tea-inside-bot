<?php

namespace Lang;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class LanguagesMap
{
	public static $map = [
		"ID" => "Lang\\ID",
		"EN" => "Lang\\EN"
	];

	public static function languageExists($lang)
	{
		return isset(self::$map[$lang]);
	}
}