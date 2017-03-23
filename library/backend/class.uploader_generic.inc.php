<?php
namespace backend;

/**
 * Few generic features holder of the uploader
 */
class uploader_generic
{
	# where to uplod a file
	protected $destination = '/tmp';
	protected $destination_url = '/images/services'; # relative path to the URL beig uploaded

	# Name of the file being uploaded
	protected $name = 'uploader';
	# <input type="file" name="uploader" id="uploader" value="" />

	/**
	 * Call this, along with the child's constructor
	 * This does not accept paths like ../, /
	 */
	public function __construct($where = '/tmp', $destination_url = '/images', $make_directory = false, $record_id = 0)
	{
		if(!is_dir($where))
		{
			# Optionally, try to make the directory
			# Be careful! The user might have sent it wrongly.
			if($make_directory === true)
			{
				if(!mkdir($where, 0777, true))
				{
					throw new \Exception('Cannot create directory: ' . $where);
				}
			}
			else
			{
				throw new \Exception('Upload path does not exist, and I am not told to make it: ' . $where);
			}
		}
		else if(!is_writable($where))
		{
			throw new \Exception("Cannot upload to: {$where}");
		}

		$this->destination = trim($where);

		# Special protection measures
		$this->destination_url = $destination_url;
		$this->destination_url = str_replace('..', "", $this->destination_url); # disallow any guessed paths
		$this->destination_url = preg_replace('#/+#', '/', $this->destination_url);

		# Do not allow to write to the root.
		$this->destination_url = preg_replace('#^/#is', "", trim($this->destination_url));
	}

	/**
	 * Upload the file into the location defined by the child class.
	 */
	public function upload($extension = "", $filename = "")
	{
		if($filename == "")
		{
			# If file name is missing, applies the default, random generated file name.
			$filename = date('YmdHis') . mt_rand(1000, 9999);
			$filename .= ($extension) ? '.' . preg_replace('#^\.#is', "", $extension) : "";
		}

		if(!is_writable($this->destination))
		{
			throw new \Exception('Cannot write to: ' . $this->destination);
		}
		else
		{
			if(!move_uploaded_file($_FILES[$this->name]['tmp_name'], $this->destination . '/' . $filename))
			{
				throw new \Exception("Upload failed: {$_FILES[$this->name]['tmp_name']} to {$this->destination}/{$filename}");
			}
		}

		return $filename;
	}

	public function patch($filename = 'YYYYMMDDHHIISSXXXX', $record_id = 0, $params = array())
	{
	}
}
