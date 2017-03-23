<?php
namespace images;

/**
 * Thumbnail generator (currently supports jpeg only)
 *
 * @package Common
 */
class thumbnailer
{
	public $original = array();
	private $dimension;

	public function __construct($original_name = "")
	{
		if(is_file($original_name))
		{
			$this->original = array(
				'name' => "",
				'mime' => "",
			);

			if($size = getimagesize($original_name))
			{
				$this->original['name'] = $original_name; # '/tmp/test.jpg'; # Put absolute or relative path name
				list($this->original['width'], $this->original['height']) = $size;

				$this->original['mime'] = strtolower($size['mime']);

				$this->dimension = new dimensions($this->original['width'], $this->original['height']);
			}
			else
			{
				# We are working with a NON-IMAGE!
				#die("Image file {$original_name} is NOT valid for processing.");
			}
		}
		else
		{
			# die("File {$original_name} does not exist");
		}
	}

	public function generate($new_width = 0, $new_height = 0, $thumb_file = "", $quality = 75)
	{
		$quality = (int)$quality;
		$success = false;

		$new_width = (int)$new_width;
		$new_height = (int)$new_height;

		# If we need propertional resizing
		if(is_object($this->dimension))
		{
			$this->dimension->canvas($new_width, $new_height);
			$new_width = $this->dimension->get_width();
			$new_height = $this->dimension->get_height();
		}

		if($this->original['name'] == $thumb_file)
		{
			throw new \Exception('Thumbnail should be of different file than the original.');
		}

		# Verifies that only currently considered file will be resized.
		if($this->original)
		{
			$source = null; # The parent image source
			$thumb = imagecreatetruecolor($new_width, $new_height);

			switch($this->original['mime'])
			{
				case 'image/jpeg':
					$source = imagecreatefromjpeg($this->original['name']);
					break;
				case 'image/png':
					$source = imagecreatefrompng($this->original['name']);
					break;
				case 'image/gif':
					$source = imagecreatefromgif($this->original['name']);
					break;
				default:
					$source = null;
			}

			# Resize the image into new dimensions
			if($source && imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $this->original['width'], $this->original['height']))
			{
				# Output (saves to an output file immediately)
				#die("{$thumb}, {$thumb_file}, {$quality}");
				$success = imagejpeg($thumb, $thumb_file, $quality);
			}
			else
			{
				# You probably used gif/png or other unsupported image file formats.
			}
		}

		return $success;
	}
}
