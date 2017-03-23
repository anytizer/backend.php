<?php
namespace common;

/**
 * Provides a better directory location.
 *
 * @package Common
 */
class directory
{
	private $number;

	/**
	 * @param int $number
	 */
	public function __construct($number = 0)
	{
		$this->number = (int)$number;
		$this->digits = 6; # 000,000 => 999,999 items
	}

	/**
	 * @param string $location
	 */
	public function create($location = '.')
	{
		$string = (string)preg_replace('/[^\d]+/is', "", $this->number);
		$numbers = str_split($string);

		#\common\stopper::debug($numbers, true);
		#$location = (string)preg_replace('/[^a-zA-Z\d\_]+/is', "", $location);
		$location = (string)preg_replace('/[^a-zA-Z\d\_\.\/]+/is', "", $location);

		trim($location, " \t\n\r\0\x0B/\\");
		foreach($numbers as $i => $digit)
		{
			$location .= "/{$digit}";
			#\common\stopper::debug("\nMaking:{$location}", true);

			if(!is_dir($location))
			{
				mkdir($location, 0777);
			}
		}
	}

	/**
	 * @return string
	 */
	public function get_path()
	{
		$path = implode('/', str_split((string)preg_replace('/[^\d]+/is', "", $this->number)));

		return $path;
	}
}
