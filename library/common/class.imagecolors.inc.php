<?php
namespace common;

/**
 * Resizes images and finds out the most significant colors found in an image
 */
class imagecolors
{
	private $debug = false;

	/**
	 * Size of the original image being processed
	 */
	private $source_width = 0;
	private $source_height = 0;

	/**
	 * Maximum resize width/height allowed
	 * Do not modify the default values of 256 x 256
	 * Higher number of this dimension adversly affect the system performance
	 */
	private $resize_width_max = 64;
	private $resize_height_max = 64;
	private $threshold_coverage = 0; # at least a color should cover this %age to be considered
	private $maximum_colors = 7; # How many colors to draw from the top ranks

	/**
	 * Newly calculated resized image dimension (lesser than maximum resize width/height allowed
	 */
	private $resizeto_width = 0;
	private $resizeto_height = 0;

	private $original_filename = "";
	private $image = null;

	private $palettes = array();
	private $statistics = array();

	# COLOR object
	private $colors = null;

	public $pixels = 0; # Number of pixels processed

	/**
	 * @todo Fix the class file
	 */
	public function __construct()
	{
	}
	
	
	public function process($original_filename = "")
	{
		if(!is_file($original_filename))
		{
			throw new \Exception("Cannot proceed image file.");
		}

		$this->original_filename = $original_filename;

		/**
		 * sRGB color palettes
		 *
		 * @link http://en.wikipedia.org/wiki/Web_colors
		 * @link http://home.comcast.net/~rblwood/Colour.htm
		 */
		$srgb = array();
		$srgb[] = 'FFFFFF';
		$srgb[] = 'C0C0C0';
		$srgb[] = '808080';
		$srgb[] = '000000';
		$srgb[] = 'FF0000';
		$srgb[] = '800000';
		$srgb[] = 'FFFF00';
		$srgb[] = '808000';
		$srgb[] = '00FF00';
		$srgb[] = '008000';
		$srgb[] = '00FFFF';
		$srgb[] = '008080';
		$srgb[] = '0000FF';
		$srgb[] = '000080';
		$srgb[] = 'FF00FF';
		$srgb[] = '800080';

		/**
		 * Color palettes used in google image search settings
		 */
		$google_colors = array(
			'cc0000',
			'ff9900',
			'ffff00',
			'00cc00',

			'00cccc',
			'0000ff',
			'663399',
			'ff99cc',

			'ffffff',
			'999999',
			'000000',
			'996600'
		);


		/**
		 * Custom palettes: Relatively better one
		 */
		$custom_palettes = array();
		$custom_palettes[] = 'FFFFFF';
		#$custom_palettes[]='FFFF66';
		$custom_palettes[] = 'FFFF00';
		$custom_palettes[] = 'FF9933';
		$custom_palettes[] = 'FFCCFF';
		$custom_palettes[] = 'FF00FF';
		$custom_palettes[] = 'FF0000';
		$custom_palettes[] = 'CCCCCC';
		#$custom_palettes[]='CCCC00';
		#$custom_palettes[]='CC6633';
		$custom_palettes[] = 'CC3300';
		#$custom_palettes[]='C0C0C0';
		$custom_palettes[] = '99CCFF';
		$custom_palettes[] = '808000';
		$custom_palettes[] = '800080';
		$custom_palettes[] = '669933';
		$custom_palettes[] = '660000';
		#$custom_palettes[]='336600';
		$custom_palettes[] = '00FFFF';
		$custom_palettes[] = '00FF00';
		$custom_palettes[] = '008000';
		$custom_palettes[] = '003399';
		#$custom_palettes[]='333399';
		$custom_palettes[] = '0000FF';
		$custom_palettes[] = '000000';

		# Which color set do you prefer?
		#$this->palettes = $srgb;
		#$this->palettes = $google_colors;
		$this->palettes = $custom_palettes;

		$this->palettes = array_map('strtoupper', $this->palettes);
		rsort($this->palettes);

		# For all colors in the list, choose the minimal distance
		$this->colors = new colors();
	}

	/**
	 * Give the palette colors
	 */
	public function palettes()
	{
		return $this->palettes;
	}

	/**
	 * Resize an original image into memory for temporary processing
	 *
	 * @see cropnail::resize() alias
	 */
	public function resize()
	{
		/**
		 * Find out the source image size
		 */
		$source_sizes = getimagesize($this->original_filename);
		if(!$source_sizes)
		{
			return false;
		}
		$this->source_width = $source_sizes[0];
		$this->source_height = $source_sizes[1];
		#print_r($source_sizes);

		/**
		 * When both the original dimensions are smaller than maximum allowed, just use them.
		 */
		if($this->source_width <= $this->resize_width_max && $this->source_height <= $this->resize_height_max)
		{
			$this->resizeto_width = $this->source_width;
			$this->resizeto_height = $this->source_height;
		}
		else
		{
			/**
			 * Dynamically choose width or height and calculate the other dimension to maximum fillup the allowed space
			 */
			if($this->source_width / $this->resize_width_max < $this->source_height / $this->resize_height_max)
			{
				#die('calc width');
				$this->resizeto_width = floor($this->source_width * $this->resize_height_max / $this->source_height);
				$this->resizeto_height = $this->resize_height_max;
			}
			else
			{
				#die('calc height');
				$this->resizeto_width = $this->resize_width_max;
				$this->resizeto_height = floor($this->source_height * $this->resize_width_max / $this->source_width);
			}
		}

		$this->pixels = $this->resizeto_width * $this->resizeto_height;

		/**
		 * Canvas for target image
		 * Produce the croped thumbnail (actual cropnail)
		 */
		#die("Destination dimensions: {$this->resizeto_width}, {$this->resizeto_height}");
		$destination = imagecreatetruecolor($this->resizeto_width, $this->resizeto_height);


		/**
		 * Fillup all the white colors
		 *
		 * @todo When processing transparent png images, it might result to wrong colors listing
		 */
		$white = imagecolorallocate($destination, 255, 255, 255);
		imagefilledrectangle($destination, 0, 0, $this->resizeto_width, $this->resizeto_height, $white);


		/**
		 * Support resizing of multiple image types
		 */
		$source = null;
		$imagesize = getimagesize($this->original_filename);
		switch(strtolower($imagesize['mime']))
		{
			case 'image/png':
				$source = imagecreatefrompng($this->original_filename);
				break;
			case 'image/gif':
				$source = imagecreatefromgif($this->original_filename);
				break;
			case 'image/jpeg':
				$source = imagecreatefromjpeg($this->original_filename);
				break;
			default:
				return null;
		}

		/**
		 * Actually produce the cropnail image content in the memory
		 * Save memory by resizing original image to this size
		 */
		imagecopyresampled(
			$destination, $source,
			0, 0,
			0, 0,
			$this->resizeto_width, $this->resizeto_height,
			$this->source_width, $this->source_height
		);

		/**
		 * Only for test/debug purpose
		 *
		 * @todo Remove the below line in production environment.
		 */
		#imagejpeg($destination, 'c:/a.jpg', 100);
		#imagejpeg($destination, 'c:/'.basename($this->original_filename), 100); # better
		#die('Resized image dumped.');

		return $destination;
	}

	/**
	 * Build a list of top colors
	 * Warning: It is very CPU intensive feature
	 */
	public function top_colors()
	{
		$image = $this->resize();

		if(!$image)
		{
			return null;
		}

		$this->statistics = array();

		#$this->resizeto_width = imagesx($image);
		#$this->resizeto_height = imagesy($image);
		#die("Resize dimensions: {$this->resizeto_width}x{$this->resizeto_height}");
		for($x = 0; $x < $this->resizeto_width; ++$x)
		{
			for($y = 0; $y < $this->resizeto_height; ++$y)
			{
				$color_index = imagecolorat($image, $x, $y);
				$color_tran = imagecolorsforindex($image, $color_index);
				#print_r($color_tran); die('color tran');

				$color = sprintf('%02X%02X%02X', $color_tran['red'], $color_tran['green'], $color_tran['blue']);

				$converted_color = $this->nearest_color($color);
				#if($this->debug) echo "\r\nConverting {$color} @ {$x},{$y} = {$converted_color}";

				$this->statistics[$converted_color] = array(
					'color' => $converted_color,
					'weight' => 1 + (isset($this->statistics[$converted_color]['weight']) ? $this->statistics[$converted_color]['weight'] : 0),
					'rank' => "", # calculate it later on
					'percentage' => "", # calculate it later on
				);
			}
		}
		#arsort($this->statistics, SORT_NUMERIC);
		uasort($this->statistics, array($this, 'custom_sorter'));

		$rank = 0; # 1 to ... n, low = high coverage
		foreach($this->statistics as $color => $stats)
		{
			$this->statistics[$color]['percentage'] = $this->statistics[$color]['weight'] * 100 / $this->pixels;

			if($this->threshold_coverage && $this->statistics[$color]['percentage'] < $this->threshold_coverage)
			{
				unset($this->statistics[$color]);

				# Do not calculate the ranks for minor colors
				continue;
			}
			$this->statistics[$color]['rank'] = ++$rank;
		}

		#print_r($this->statistics);

		/**
		 * @todo Filter the minimum threshold coverage colors as well (most significant colors only)
		 */
		$this->statistics = array_slice($this->statistics, 0, $this->maximum_colors, true);

		return $this->statistics;
	}

	/**
	 * Reverse order sorter based on calculated weight
	 */
	private function custom_sorter($statistics1 = array(), $statistics2 = array())
	{
		if($statistics1['weight'] == $statistics1['weight'])
		{
			0;
		}

		$value = ($statistics1['weight'] < $statistics2['weight']) ? 1 : -1;
		return $value;
	}

	/**
	 * Finds out the nearest color in the palette
	 * Warning: It is very CPU intensive feature when used in multiple loops
	 */
	private function nearest_color($rrggbb = '000000')
	{
		$nearest_color = null;

		# Set as the maximun distance between two end points in the color depth
		$previous_distance = $this->colors->distance('000000', 'FFFFFF');
		foreach($this->palettes as $p => $color)
		{
			#die("Requesting the distance between #{$color} and #{$rrggbb}.");
			$distance = $this->colors->distance($color, $rrggbb);
			if($distance < $previous_distance)
			{
				# Set the new minimal distance
				$previous_distance = $distance;
				$nearest_color = $color;
			}
			#if($this->debug) echo "\r\ndistance({$color}, {$rrggbb}) = {$distance}";
		}
		#if($this->debug) echo("\r\nThat was a single color distance calculation for {$rrggbb}: {$nearest_color} @{$distance}!");
		#if($this->debug) echo("  {$rrggbb}: {$nearest_color} @{$distance}!");

		return $nearest_color;
	}

	/**
	 * Translates a color into RRGGBB format form a translated color
	 */
	private function rgb_color($color_translation = array('red' => null, 'green' => null, 'blue' => null, 'alpha' => null))
	{
		#print_r($color_translation); die('that color?');
		return sprintf('%02X%02X%02X', $color_translation['red'], $color_translation['green'], $color_translation['blue']);
	}


	/**
	 * Print out the palette swatches
	 */
	public function __toString()
	{
		$output = '<div class="color-swatches">';
		foreach($this->palettes as $color)
		{
			$color = "#{$color}";
			$output .= "<div class='color-block' style='background-color:{$color}' title='{$color}'></div>";
		}
		$output .= '</div>';

		return $output;
	}
}

/**
 * Usage examples
 * $colors = new colors();
 * $original_filename='distance/nexen.png';
 * $ic = new imagecolors($original_filename);
 * $colors = $ic->top_colors();
 * print_r($ic);
 * echo '<style type="text/css">td { width:40px; height:40px; }</style>';
 * echo "<div><img src='{$original_filename}' /></div>";
 * echo '<table border="0">';
 * foreach($colors as $color => $count)
 * {
 * echo "
 * <tr>
 * <td style='background:#{$color};'></td>
 * <td>#{$color}</td>
 * <td align='right'>{$count}</td>
 * </tr>";
 * }
 * echo '</table>';
 */
