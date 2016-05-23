<?php
namespace others;

/**
 * Data Type for Image Dimensions - Height, Weight, Size
 *
 * @package Interfaces
 */
class image_dimensions
{
	public $size = 0;
	public $width = 0;
	public $height = 0;

	public function __construct($image_file = '')
	{
		/**
		 * @todo Validate image file with gd_info().
		 */
		if (file_exists($image_file) && ($sizes = getimagesize($image_file))) {
			$this->width = $sizes[0];
			$this->height = $sizes[1];

			$this->size = filesize($image_file);
		}
	}
}
