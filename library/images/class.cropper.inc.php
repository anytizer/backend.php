<?php
namespace images;

/**
 * Image cropping interface
 */
class cropper
{
	/**
	 * Image dimensions
	 */
	private $width = 0;
	private $height = 0;

	private $quality = 75;

	/**
	 * Images being cropped
	 */
	private $source = "";
	private $destination = "";

	private $errors = array(
		'destination_exists' => 'Desitntion exists already.',
		'destination_writeerror' => 'Cannot write to the destination: ',
		'source_file_not_found' => 'Source file not found',
		'interface_missing' => 'Interface does not exist: ',
	);

	private $interface_file = 'cropper_interface.php';

	/**
	 * @todo Fix the class file
	 */
	public function __construct()
	{
	}
	
	/**
	 * Put the default values to zero
	 */
	public function crop($width = 0, $height = 0, $interface_file = 'interface.php')
	{
		$width = (int)$width;
		$height = (int)$height;

		$variable = new \common\variable();

		if($width > 0 && $height > 0)
		{
			$this->width = (int)$width;
			$this->height = (int)$height;

			$_SESSION['cropper']['width'] = $this->width;
			$_SESSION['cropper']['height'] = $this->height;
		}
		else
		{
			if(!isset($_SESSION['cropper']['width']))
			{
				$_SESSION['cropper']['width'] = 0;
			}
			if(!isset($_SESSION['cropper']['height']))
			{
				$_SESSION['cropper']['height'] = 0;
			}

			$this->width = (int)$_SESSION['cropper']['width'];
			$this->height = (int)$_SESSION['cropper']['height'];
		}

		$this->source = isset($_SESSION['cropper']['source']) ? $_SESSION['cropper']['source'] : "";
		$this->destination = isset($_SESSION['cropper']['destination']) ? $_SESSION['cropper']['destination'] : "";

		if(is_file($interface_file))
		{
			$this->interface_file = $interface_file;
		}
		else
		{
			/**
			 * Valid interface file required
			 */
			trigger_error("Need a valid interace file. <strong>{$interface_file}</strong> does not exist.", E_USER_ERROR);
		}
	}

	public function crop_interface($source = "", $destination = "")
	{
		if(is_file($destination))
		{
			/**
			 * Destination should not exist
			 */
			trigger_error($this->errors['destination_exists'] . ': ' . $destination, E_USER_ERROR);
		}
		else if(!is_writable(dirname($destination)))
		{
			/**
			 * Destination should be writable
			 */
			trigger_error($this->errors['destination_writeerror'] . $destination, E_USER_ERROR);
		}
		else
		{
			$_SESSION['cropper']['destination'] = $destination;
		}

		if(is_file($source))
		{
			/**
			 * We must have access to physical image file first
			 */
			$_SESSION['cropper']['source'] = $this->source = $source;
			$this->show_interface();
		}
		else
		{
			trigger_error($this->errors['source_file_not_found'] . $source, E_USER_ERROR);
		}
	}

	/**
	 * Loads the HTML to show the image cropping interface
	 */
	private function show_interface()
	{
		$width = $this->width;
		$height = $this->height;
		$source = $this->source;

		if(is_file($this->interface_file))
		{
			require_once($this->interface_file);
		}
		else
		{
			trigger_error($this->errors['interface_missing'] . ($this->interface_file), E_USER_ERROR);
		}
	}


	/**
	 * Session/Post have the information on what file to crop and in which dimensions.
	 * Crop and save the file accordingly.
	 */
	public function crop_preset($show_image = false)
	{
		$crop = $_POST['crop'];
		$crop['file'] = $this->source;
		if(!is_file($crop['file']))
		{
			# Particulalry on the double-form submissions, this can happen.
			# By resetting the session cropper to null.
			return false;
		}

		# Whatever was the crop size selected, what is the size to load?
		$new = array(
			# also known as the aspect ratio
			'width' => $this->width,
			'height' => $this->height,
		);

		# Good for as selected by the user
		$thumb = imagecreatetruecolor($new['width'], $new['height']);
		$source = imagecreatefromjpeg($crop['file']);
		$x = $crop['x1'];
		$y = $crop['y1'];
		$w = $new['width']; # 550;
		$h = $new['height']; #600;
		imagecopyresampled($thumb, $source, 0, 0, $x, $y, $w, $h, $crop['width'], $crop['height']);

		if($show_image === true)
		{
			header('Content-type: image/jpeg');
			$success = imagejpeg($thumb, null, $this->quality);
		}
		else
		{
			$success = imagejpeg($thumb, $this->destination, $this->quality);
		}
		imagedestroy($thumb);

		$_SESSION['cropper'] = array();

		return $success;
	}
}