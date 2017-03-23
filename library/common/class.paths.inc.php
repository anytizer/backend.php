<?php
namespace common;

/**
 * Creates a unique path for an ID.
 * Helpful in multi-images of an object.
 *
 * @package Common
 */
class paths
{
	private $blocks;
	private $path;

	public function __construct($id = 0)
	{
		$id += 0;
		$path = strtoupper(strrev(sha1('COMPANY' . $id . 'NAME', false)));

		$paths = array();
		preg_match_all('/([A-Z0-9]{8})/is', $path, $paths);

		$this->blocks = array();
		foreach($paths[1] as $i => $block)
		{
			$this->blocks[chr(65 + $i)] = $block;
		}

		$this->path = $path;
	}

	public function block($letter = 'A')
	{
		return isset($this->blocks[$leter]) ? $this->blocks[$leter] : "";
	}

	public function create($directory = './')
	{
		$success = true;
		$dir = $directory;
		foreach($this->blocks as $block => $name)
		{
			$dir .= '/' . $name;
			if(!is_dir($dir))
			{
				if(!mkdir($dir, 0777, true))
				{
					$success = false;
				}
			}
		}
		
		return $success;
	}
}
