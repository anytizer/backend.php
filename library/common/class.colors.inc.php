<?php
namespace common;

/**
 * The colors bank and processor
 * Helps to find out the nearest useful color of any given color
 *
 * @package Common
 */
class colors
{
	/**
	 * Most useful primary colors are: 0, 3, 6, 9, C, F (first digit)
	 * Most useful secondary colors: 0, 8, F (second digit)
	 */
	private $units = array('0', '3', '6', '9', 'C', 'F');

	public function __construct()
	{
	}

	/**
	 * Convert a color into nearest easy color
	 *
	 * @param string $rrggbb
	 *
	 * @return mixed|null
	 */
	public function proximal($rrggbb = '000000')
	{
		if(!($rrggbb = $this->sanitize($rrggbb)))
		{
			return null;
		}

		$conversion = array(
			#'0' => '0',
			'1' => '0',
			'2' => '3',
			#'3' => '3',
			'4' => '3',
			'5' => '6',
			#'6' => '6',
			'7' => '6',
			'8' => '9',
			#'9' => '9',
			'A' => '9',
			'B' => 'C',
			#'C' => 'C',
			'D' => 'C',
			'E' => 'F',
			#'F' => 'F',
		);

		/*$rgb = str_split(strtoupper($rrggbb));
		foreach($rgb as $c => $color)
		{
			if(isset($conversion[$color]))
			{
				$rgb[$c] = $conversion[$color];
			}
		}
		return implode('', $rgb);*/

		return str_replace(array_keys($conversion), array_values($conversion), $rrggbb);
	}

	/**
	 * Inverts the colors with most distant color
	 *
	 * @param string $rrggbb
	 *
	 * @return mixed|null
	 */
	function invert($rrggbb = '000000')
	{
		if(!($rrggbb = $this->sanitize($rrggbb)))
		{
			return null;
		}

		# @todo: Problem: Central colors are NOT inverted properly
		$inversion_set1 = array(
			'F' => '0',
			'E' => '1',
			'D' => '2',
			'C' => '3',
			'B' => '4',
			'A' => '5',
			'9' => '6',
			'8' => '7',
			'7' => '8',
			'6' => '9',
			'5' => 'A',
			'4' => 'B',
			'3' => 'C',
			'2' => 'D',
			'1' => 'E',
			'0' => 'F'
		);

		# @todo There is no exact flipping
		$inversion_set2 = array();
		for($i = 0; $i <= 15; ++$i)
		{
			$digit = sprintf('%1XF', $i);
			$inversion_set2[$digit] = sprintf('%1XF', ~$i);
		}

		return str_replace(array_keys($inversion_set2), array_values($inversion_set2), $rrggbb);
	}

	/**
	 * List out an empty color palette
	 *
	 * @return array
	 */
	public function palette_rrggbb()
	{
		$palettes = array();
		$length = count($this->units);
		for($r = 0; $r < $length; ++$r)
		{
			for($g = 0; $g < $length; ++$g)
			{
				for($b = 0; $b < $length; ++$b)
				{
					$color = "{$this->units[$r]}{$this->units[$r]}{$this->units[$g]}{$this->units[$g]}{$this->units[$b]}{$this->units[$b]}";
					$palettes[] = $color;
				}
			}
		}

		return $palettes;
	}

	/**
	 * List out short colors
	 *
	 * @return array
	 */
	public function palette_rgb()
	{
		$palettes = array();
		$length = count($this->units);
		for($r = 0; $r < $length; ++$r)
		{
			for($g = 0; $g < $length; ++$g)
			{
				for($b = 0; $b < $length; ++$b)
				{
					$color = "{$this->units[$r]}{$this->units[$g]}{$this->units[$b]}";
					$palettes[$color] = array();
				}
			}
		}

		return $palettes;
	}

	/**
	 * List out red, green and blue color data in hex
	 *
	 * @param string $rrggbb
	 *
	 * @return array|null
	 */
	public function rgb($rrggbb = '000000')
	{
		if(!($rrggbb = $this->sanitize($rrggbb)))
		{
			return null;
		}

		$data = array();
		preg_match('/^([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})$/is', $rrggbb, $data);
		$rgb = array(
			'red' => hexdec($data[1]),
			'green' => hexdec($data[2]),
			'blue' => hexdec($data[3])
		);

		return $rgb;
	}

	/**
	 * Finds out the distance between two colors in the three dimensions of R, G, and B
	 * Warning: It is very CPU intensive feature when used in multiple loops
	 * Maximum distance is between 000000 and FFFFFF: 441.67295593006
	 *
	 * @param string $rrggbb1
	 * @param string $rrggbb2
	 *
	 * @return float|null
	 */
	public function distance($rrggbb1 = '000000', $rrggbb2 = '000000')
	{
		#Distance between #{$rrggbb1} and #{$rrggbb2}

		# For speed, because, rgb() itself will validate each color
		#if(!($rrggbb1 = $this->sanitize($rrggbb1))) return null;
		#if(!($rrggbb2 = $this->sanitize($rrggbb2))) return null;

		$rgb1 = $this->rgb($rrggbb1);
		$rgb2 = $this->rgb($rrggbb2);
		if(!$rgb1 || !$rgb2)
		{
			return null;
		}

		# Distance formula
		$distance = sqrt(
			pow($rgb1['red'] - $rgb2['red'], 2) +
			pow($rgb1['green'] - $rgb2['green'], 2) +
			pow($rgb1['blue'] - $rgb2['blue'], 2)
		);

		return $distance;
	}

	/**
	 * Color sanitization
	 * Accepts only RRGGBB values in a color string
	 * Alphanetic digits are used in CAPITAL letters
	 *
	 * @param string $rrggbb
	 *
	 * @return mixed
	 */
	private function sanitize($rrggbb = '000000')
	{
		return preg_replace('/[^0-9A-F]+/s', '', strtoupper($rrggbb));
	}
}

