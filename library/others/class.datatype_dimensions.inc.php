<?php
namespace others;

/**
 * Image dimensions (width/height)
 *
 * @package Interfaces
 */
class datatype_dimensions
	extends \abstracts\datatype
{
	private static $resizes = array();

	public function __construct($width = 0, $height = "")
	{
		parent::__construct(array(
			'width',
			'height'
		));

		$this->resizes[] = array(
			'width' => abs((int)$width),
			'height' => abs((int)$height),
		);
	}
}
