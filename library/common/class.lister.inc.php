<?php
namespace common;

/**
 * Lists out the files under a path.
 * Copies subdirectories
 *
 * @example $path = '/home/USER/PROJECTS/project';
 * @example (new lister())->files($path)->copy_to('/tmp/newpath');
 * @example (new lister())->images($path)->copy_to('/tmp/images');
 */
class lister
{
	private $filters = array(
		'.', 
		'..', 
		'.svn', 
		'.git',
		'.idea',
		'out'
	);
	private $source_path = '/tmp';
	private $files = array();

	/**
	 * Reject certain names globally
	 */
	private function _filter($filename='readme.txt')
	{
		if(in_array($filename, $this->filters)) return null;
		return true;
	}
	
	/**
	 * Limit the lists into known image types only
	 */
	private function _filter_images($filename='readme.txt')
	{
		return preg_match('/\.(jpg|png|gif)$/', $filename);
	}
	
	/**
	 * Extract the path relative to $this->source_path
	 */
	private function _replace_source($path='/tmp')
	{
		$path = preg_replace('/^'.preg_quote($this->source_path).'\/?/', '', $path);
		return $path;
	}


	/**
	 * Recursively scan through a path
	 */
	private function _scan_all_files($path='/tmp')
	{
		$myself = __FUNCTION__;
		$final = array();
		$files = scandir($path);
		$files = array_filter($files, array($this, '_filter'));

		#print_r($files);
		foreach($files as $file)
		{
			$full_path = $path.'/'.$file;
			if(is_dir($full_path))
			{
				$new_list = $this->$myself($full_path);
				#print_r($new_list);
				$final = array_merge($final, $new_list);
			}
			else if(is_file($full_path))
			{
				$final[] = $full_path;
			}
		}
		return $final;
	}
	
	/**
	 * Scan all files
	 */
	public function files($source_path='/tmp')
	{
		$source_path = realpath($source_path);
		if(!$source_path) return false;

		$this->source_path = $source_path;
		$files = $this->_scan_all_files($this->source_path);
		$files = array_map(array($this, '_replace_source'), $files);
		$this->files = $files;
		
		return $this;
	}
	
	public function images($source_path='/tmp')
	{
		$this->files($source_path);
		$this->files = array_filter($this->files, array($this, '_filter_images'));
		
		#print_r($this->files); die('Images only');
		
		return $this;
	}
	
	public function copy_to($new_path='/tmp')
	{
		foreach($this->files as $file)
		{
			$target_file = $new_path.'/'.$file;
			echo $target_file, "\r\n";
			
			$target_dir = dirname($target_file);
			if(!is_dir($target_dir))
			{
				mkdir($target_dir, 0777, true);
			}
			
			copy($this->source_path.'/'.$file, $target_file);
		}
	}
	
	/**
	 * Count of total files read out
	 */
	public function total()
	{
		return count($this->files);
	}
}
