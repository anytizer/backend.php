<?php
namespace images;

/**
 * Image cropping interface - Quicker verrsion
 */
class cropper_quick
{
	/**
	 * Session/Post have the information on what file to crop and in which dimensions.
	 * Crop and save the file accordingly.
	 */
	public function crop($source_image = "", $width = 0, $height = 0, $destination = "")
	{
		# Whatever was the crop size selected, what is the size to load?
		$new = array(
			# also known as the aspect ratio
			'width' => $width,
			'height' => $height,
		);

		$crop = array(
			'file' => $source_image,
			'x1' => 0,
			'y1' => 0,
		);

		# Good for as selected by the user
		$thumb = imagecreatetruecolor($new['width'], $new['height']);
		$source = imagecreatefromjpeg($crop['file']);
		$x = $crop['x1'];
		$y = $crop['y1'];
		$w = $new['width']; # 550;
		$h = $new['height']; #600;

		$info = array();
		list($info['width'], $info['height'], $info['type'], $info['attr']) = getimagesize($source_image);
		#print_r($info);

		imagecopyresized($thumb, $source, 0, 0, 0, 0, $new['width'], $new['height'], $info['width'], $info['height']);

		$success = imagejpeg($thumb, $destination, 100);

		return imagedestroy($thumb);
	}

	public function crop_ratio($source_image = "", $ratio = 0.3, $destination = "")
	{
		$info = array();
		list($info['width'], $info['height'], $info['type'], $info['attr']) = getimagesize($source_image);
		#print_r($info);

		# Whatever was the crop size selected, what is the size to load?
		$new = array(
			# also known as the aspect ratio
			'width' => $info['width'] * $ratio,
			'height' => $info['height'] * $ratio,
		);

		$crop = array(
			'file' => $source_image,
			'x1' => 0,
			'y1' => 0,
		);

		# Good for as selected by the user
		$thumb = imagecreatetruecolor($new['width'], $new['height']);
		$source = imagecreatefromjpeg($crop['file']);
		$x = $crop['x1'];
		$y = $crop['y1'];
		$w = $new['width']; # 550;
		$h = $new['height']; #600;

		imagecopyresized($thumb, $source, 0, 0, 0, 0, $new['width'], $new['height'], $info['width'], $info['height']);

		$success = imagejpeg($thumb, $destination, 100);

		return imagedestroy($thumb);
	}


	public function crop_percent($source_image = "", $percent = 30, $destination = "")
	{
		$info = array();
		list($info['width'], $info['height'], $info['type'], $info['attr']) = getimagesize($source_image);
		#print_r($info);

		# Whatever was the crop size selected, what is the size to load?
		$new = array(
			# also known as the aspect ratio
			'width' => ceil($info['width'] * $percent / 100),
			'height' => ceil($info['height'] * $percent / 100),
		);

		$crop = array(
			'file' => $source_image,
			'x1' => 0,
			'y1' => 0,
		);

		# Good for as selected by the user
		$thumb = imagecreatetruecolor($new['width'], $new['height']);
		$source = imagecreatefromjpeg($crop['file']);
		$x = $crop['x1'];
		$y = $crop['y1'];
		$w = $new['width']; # 550;
		$h = $new['height']; #600;

		imagecopyresized($thumb, $source, 0, 0, 0, 0, $new['width'], $new['height'], $info['width'], $info['height']);

		$success = imagejpeg($thumb, $destination, 100);

		return imagedestroy($thumb);
	}
}
