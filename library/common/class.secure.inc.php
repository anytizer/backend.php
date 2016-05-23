<?php
namespace common;

/**
 * Generates a CAPTCHA code - Really Simple!
 * @uses `__LIBRARY_PATH__`
 */
class secure
{
	public $font = 'AHGBold.ttf'; # LSANSI.TTF'; # 'HARLOWSI.TTF'; # best selected

	public function __construct($show = false)
	{
		# http://www.fontspace.com/category/bold
		$this->font = __LIBRARY_PATH__ . '/inc/Playball.ttf';
	} # __construct()

	public function generate_code($characters = 5)
	{
		$possible = '09876543'; # Good, non-confusing characters
		$security_code = '';
		for($i = 0; $i < $characters && $i <= 10; ++$i)
		{
			$security_code .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
		}

		#\common\stopper::message("<HR>{$security_code}<HR>");
		return $security_code;
	} # generate_code

	public function generate_code_math()
	{
		$operators = array();
		#$operators[]='-'; # Can cause negative numbers
		$operators[] = '+';
		$operators[] = '*';

		$operator = $operators[mt_rand(0, count($operators) - 1)];

		$a = mt_rand(1, 9);
		$b = mt_rand(1, 9);

		return "\$answer = $a $operator $b;";
	}

	public function show_image($characters = 5, $is_math = false)
	{
		#if($is_math==false)
		{
			$variable = new \common\variable();
			$security_code = $this->generate_code($characters);
			$variable->write('session', 'security_code', $security_code);
		}

		$width = '120';
		$height = '40';

		# font size will be 75% of the image height
		$font_size = $height * 0.75;
		$image = @imagecreate($width, $height) or \common\stopper::message('Cannot initialize new GD image stream.');

		# set the colours
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 20, 40, 100);
		$noise_color = imagecolorallocate($image, 0xFF, 0xCC, 0xDD);

		# generate random dots in background
		for($i = 0; $i < ($width * $height) / 3; $i++)
		{
			imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $noise_color);
		}

		/* generate random lines in background */
		for($i = 0; $i < ($width * $height) / 150; $i++)
		{
			imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $noise_color);
		}

		# create textbox and add text
		$textbox = imagettfbbox($font_size, 0, $this->font, $security_code) or \common\stopper::message('Error in imagettfbbox function.');
		$x = ($width - $textbox[4]) / 2;
		$y = ($height - $textbox[5]) / 2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font, $security_code) or \common\stopper::message('Error in imagettftext function.');

		# output captcha image to browser
		imagejpeg($image);
		imagedestroy($image);

		return $security_code;
	} # show_image()


	/**
	 * Send image headers.
	 * Call it before calling the show_images()
	 */
	public function image_headers()
	{
		header("Pragma: public");
		header("Cache-Control: private", false);
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header("Content-Transfer-Encoding: binary");
		header('Accept-Ranges: bytes');
		header('Content-Type: image/jpeg');
	} # image_headers()

	public function is_secured()
	{
		# Please DO NOT re-use the session security code.
		$success = false;
		$variable = new \common\variable();
		$security_code_post = $variable->post('security_code', 'string', '');
		$security_code_session = $variable->session('security_code', 'string', '');
		if($security_code_post && $security_code_session && ($security_code_post == $security_code_session))
		{
			#echo("True!...");
			$success = true;
		}

		# Damage the security code to prevent emailing on next attempt
		$variable->write('session', 'security_code', md5(microtime()));

		return $success;
	} # is_secured()
}
