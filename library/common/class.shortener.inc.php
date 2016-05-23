<?php
namespace common;

/**
 * To-and-Fro conversion of string into integers and vice-versa.
 * @see http://briancray.com/2009/08/26/free-php-url-shortener-script/
 *
 * @package Common
 */
class shortener
{
	/**
	 * Use these character set only
	 */
	private $ALLOWED_CHARS = '';
	private $length = 0;

	/**
	 * Calculates the length on the fly.
	 */
	public function __construct()
	{
		$this->ALLOWED_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$this->length = strlen($this->ALLOWED_CHARS);
	}

	/**
	 * Converts an integer into short string
	 */
	function getShortenedURLFromID($integer = 0)
	{
		$out = '';
		while($integer > $this->length - 1)
		{
			$out = $this->ALLOWED_CHARS[fmod($integer, $this->length)] . $out;
			$integer = floor($integer / $this->length);
		}

		return $this->ALLOWED_CHARS[$integer] . $out;
	}

	/**
	 * Converts a short string into integer
	 */
	function getIDFromShortenedURL($string = '')
	{
		$this->length = strlen($this->ALLOWED_CHARS);
		$size = strlen($string) - 1;
		$string = str_split($string);
		$out = strpos($this->ALLOWED_CHARS, array_pop($string));
		foreach($string as $i => $char)
		{
			$out += strpos($this->ALLOWED_CHARS, $char) * pow($this->length, $size - $i);
		}

		return $out;
	}
}