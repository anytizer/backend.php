<?php
namespace images;

/**
 * Imprints a logo over an image
 *
 * @todo Save the image first and display the contents from there if save to is requested.
 * @todo Logo mark the image and save it, not the raw image.
 */
class logomark
{
	private $clear_too_old_images = false;
	private $logo_fullpath = '';
	private $temp_directory = '';
	private $resize_save = false; # true (test) | false
	private $resize_image = false; # true (test) | false
	private $resize = array('width' => 0, 'height' => 0);
	private $margin = 5; # pixels to leave around the logo at the corners

	private $cropnail_x = 0;
	private $cropnail_y = 0;

	public function __construct($logo_fullpath = '')
	{
		if(is_file($logo_fullpath))
		{
			$this->logo_fullpath = $logo_fullpath;
		}
		$this->temp_directory = __SUBDOMAIN_BASE__ . '/temp';
	}

	/**
	 * Resize the image before print out?
	 */
	public function resize_to($width = 0, $height = 0)
	{
		$this->resize['width'] = abs((int)$width);
		$this->resize['height'] = abs((int)$height);
		$this->resize_image = ($this->resize['width'] && $this->resize['height']);

		return $this->resize_image;
	}

	/**
	 * Save the image to the given location
	 * It is an optional patching only, before calling to show_image()
	 */
	public function save_to($fullpath = '')
	{
		/**
		 * @todo Validate the save path
		 */
		$this->resize_save = true;
		$this->save_to = $fullpath;
	}

	/**
	 * Puts a small logo on the image (bottom right corner)
	 */
	function show_image($image_fullpath = '')
	{
		if(!is_file($image_fullpath))
		{
			return null;
		}
		if(!is_file($this->logo_fullpath))
		{
			return null;
		}

		/**
		 * @todo Verify that it is an image file. Processing other kinds of files may be erraneous.
		 */
		# if (!is_image($image_fullpath)) return null;

		if($this->resize_save === true)
		{
			# self healing modlue to clean up the server's temp storage
			$old_files = glob("{$this->temp_directory}/*.tmp");
			foreach($old_files as $of => $old_file)
			{
				# 5 Minutes and old
				if((date('U') - filectime($old_file)) > 60 * 5)
				{
					unlink($old_file);
				}
			}
			$temp_file = $this->temp_directory . '/' . uniqid('temp_') . '.tmp';
			$cropnail = new cropnail(800, 600);
			$cropnail->set_xy($this->cropnail_x, $this->cropnail_y); # optional
			$cropnail->resize($image_fullpath, $temp_file);
			$image_fullpath = $temp_file; # divert to the newly resized image instead of the orignal image

			# Just copy if save_to was defined
			/**
			 * @todo Neigh, rather save after placing the logo mark.
			 */
			if($this->save_to)
			{
				/**
				 * @todo It may fail to write.
				 * @todo use $save_to instead of a temporary file.
				 */
				#copy($temp_file, $this->save_to);
			}
		}

		$source_sizes = getimagesize($image_fullpath);
		$logo_sizes = getimagesize($this->logo_fullpath);

		if(!isset($source_sizes['mime']))
		{
			return null;
		}
		if(!isset($logo_sizes['mime']))
		{
			return null;
		}

		$source = null;
		switch($source_sizes['mime'])
		{
			case 'image/jpeg':
			case 'image/jpg':
				$source = imagecreatefromjpeg($image_fullpath);
				break;
			case 'image/gif':
				$source = imagecreatefromgif($image_fullpath);
				break;
			case 'image/png':
				$source = imagecreatefrompng($image_fullpath);
				break;
			default:
				return null;
		}

		$logo = null;
		switch($logo_sizes['mime'])
		{
			case 'image/jpeg':
			case 'image/jpg':
				$logo = imagecreatefromjpeg($this->logo_fullpath);
				break;
			case 'image/gif':
				$logo = imagecreatefromgif($this->logo_fullpath);
				break;
			case 'image/png':
				$logo = imagecreatefrompng($this->logo_fullpath);
				break;
			default:
				return null;
		}

		# Check whether to resize the source
		if($this->resize_image)
		{
			$new_source = imagecreatetruecolor($this->resize['width'], $this->resize['height']);
			imagecopyresized($new_source, $source, 0, 0, 0, 0, $this->resize['width'], $this->resize['height'], $source_sizes[0], $source_sizes[1]); # distoreted
			#imagecopyresized($new_source, $source, 0, 0, 0, 0, $this->resize['width'], $this->resize['height'], $this->resize['width'], $this->resize['height']); # cropped
			$source = $new_source; # overwrite, yes
			$source_sizes = array(
				# simulate getimagesize() results
				0 => $this->resize['width'],
				1 => $this->resize['height'],
				2 => null,
				3 => "width=\"$this->resize['width']\" height=\"$this->resize['height']\"",
				'bits' => 0,
				'channels' => 0,
				'mime' => '',
			);
		}

		imagecopymerge(
			$source,
			$logo,
			($source_sizes[0] - $logo_sizes[0] - $this->margin - 1),
			($source_sizes[1] - $logo_sizes[1] - $this->margin - 1),
			0,
			0,
			$logo_sizes[0],
			$logo_sizes[1],
			75
		);

		# Save the output, if requested
		if($this->save_to)
		{
			imagepng($source, $this->save_to);
		}
		else
		{
			# Very bad, if we reach here. But show the image instantly
			$filename = \common\tools::unique_code();
			header("Content-Disposition: inline; filename=\"{$filename}.png\"");
			header("Content-Type: image/png");
			imagepng($source);
		}
	}

	/**
	 * Propagate to cropnail
	 */
	public function set_xy($x = 0, $y = 0)
	{
		$this->cropnail_x = (int)$x;
		$this->cropnail_y = (int)$y;
	}
}
