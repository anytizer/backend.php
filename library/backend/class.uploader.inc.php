<?php
namespace backend;

/**
 * Uploads a file on the server.
 * Known fault: Cannot handle files in arrays.
 */
/*
Array
(
    [client_picture] => Array
        (
            [name] => client-logo.png
            [type] => image/png
            [tmp_name] => C:\xampp\tmp\php98C4.tmp
            [error] => 0
            [size] => 2855
        )

)
Array
(
    [attachment] => Array
        (
            [name] => loading.png
            [type] => image/png
            [tmp_name] => C:\xampp\tmp\phpA8.tmp
            [error] => 0
            [size] => 608
        )

)
*/

class uploader
	extends \common\mysql
{
	public $destination = '';
	public $last_name = ''; # Name of recently uploaded file

	private $preserve_extension = false;

	/**
	 * @todo Fix this class file
	 */
	public function __construct()
	{
	}
	
	public function upload($destination_location = '', $preserve_extension = false)
	{
		# Linux/Windows Compatible location
		$destination_location = str_replace('\\', '/', $destination_location);

		# Beging with the saving location / upload directory.
		if(!is_dir($destination_location) || !is_writable($destination_location))
		{
			\common\stopper::message("Unable to use destination: <strong>{$destination_location}</strong>");

			return false;
		}
		else
		{
			$this->destination = $destination_location;
		}

		$this->preserve_extension = ($preserve_extension === true);

		parent::__construct();
	}

	/**
	 * Delete an uploaded file
	 *
	 * @todo Use a parameter and remove from physical file, database entries.
	 */
	static function upload_delete($pk_id = 0, $file_code = '')
	{
		#$file_code = addslashes($file_code);
		#$delete_sql="DELETE FROM query_uploads WHERE file_code='{$file_code}';";
		#return $this->query($delete_sql);
	}

	/**
	 * Gives the name of the file uploaded as a stamp
	 */
	public function store($index = '', $comments_additional = '')
	{
		if(!isset($_FILES[$index]))
		{
			return false;
		}
		if($_FILES[$index]['error'])
		{
			return false;
		} # Must not have any upload related errors
		if(empty($_FILES[$index]['tmp_name']))
		{
			return false;
		}
		if(empty($_FILES[$index]['name']))
		{
			return false;
		}

		$comments_additional = \common\tools::sanitize($comments_additional);
		$file_code = \common\tools::timestamp();

		if($this->preserve_extension)
		{
			# Preseve extension if any
			$info = pathinfo($_FILES[$index]['name']);
			if(isset($info['extension']))
			{
				$file_code = "{$file_code}.{$info['extension']}";
			}
		}

		$mime = addslashes($_FILES[$index]['type']);
		$name = addslashes($_FILES[$index]['name']);
		$file = $this->destination . '/' . $file_code; # Needs to be a full file name
		if(!move_uploaded_file($_FILES[$index]['tmp_name'], $file))
		{
			# File was not uploaded.
			# Instead, try to write a log file, for error-free access later on.
			if(!file_put_contents($file, "This file was not uploaded correctly: {$file} => {$name}"))
			{
				\common\stopper::message('Cannot write anything to: ' . $file);
			}
		}

		$bytes = (int)filesize($file);
		$comments = date('D, d M y H:i:s O'); # DATE_RFC822
		# Save the SQL
		$upload_sql = "
INSERT INTO `query_uploads`(
	`upload_size`, `uploaded_on`,
	`file_code`, `file_name`, `file_mime`,
	`comments_file`, `comments_additional`,
	`file_location`,
	`is_active`
) VALUES (
	'{$bytes}', CURRENT_TIMESTAMP(),
	'{$file_code}', '{$name}', '{$mime}',
	'{$comments}', '{$comments_additional}',
	'{$this->destination}',
	'Y'
);";
		$this->query($upload_sql);
		$this->last_name = $name;

		return $file_code;
	}

	/**
	 * Downloads a file, by ID or by file code.
	 */
	public function download($upload_id_or_file_code = '00000000000000000', $inline = false)
	{
		$upload_id = -1;
		$file_code = '';
		if(strlen($upload_id_or_file_code) == strlen(\common\tools::timestamp()))
		{
			# This is a file code
			$file_code = $upload_id_or_file_code;
		}
		else
		{
			# This is an ID
			$upload_id = (int)($upload_id_or_file_code);
		}

		$choose_file_sql = "
SELECT
	*
FROM query_uploads
WHERE
	(
		upload_id={$upload_id}
		OR file_code='{$file_code}'
	) AND (
		# Special protection to filter empty queries
		upload_id!=0
		AND file_code!=''
	)
LIMIT 1;";
		if($file = $this->row($choose_file_sql))
		{
			# The file exists...
			# Start the download process.
			$download = new download($inline);
			if($download->send_uploaded_file($file))
			{
				return $this->update_counter($file['upload_id']);
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Silently monitor the download counter
	 */
	private function update_counter($upload_id = 0)
	{
		$upload_id = (int)$upload_id;
		$counter_sql = "
UPDATE query_uploads SET
	downloads_counter = downloads_counter+1
WHERE
	upload_id={$upload_id}
;";
		$this->query($counter_sql);
	}

	public function file_size_mb($filename = '')
	{
		$size = $this->file_size($filename);
		$mb = number_format($size / (1024 * 1024), 2, ',', '.');

		return $mb;
	}

	public function file_size($filename = '')
	{
		$size = 0;
		if(file_exists($filename))
		{
			$size = filesize($filename);
		}

		return $size;
	}

	/**
	 * Human readable file sizes
	 */
	public function file_size_human($filename = '')
	{
		# echo("Your file: {$filename}");
		$size = $this->file_size($filename);

		$human = '-';

		if($size <= 0)
		{
			$human = '0.00 KB';
		}
		else
		{
			if($size < 1024)
			{
				$human = "{$size} Bytes";
			}
			else
			{
				if($size < (1024 * 1024))
				{
					$human = number_format($size / 1024, 2, ',', '.') . ' KB';
				}
				else
				{
					$human = number_format($size / (1024 * 1024), 2, ',', '.') . ' MB';
				}
			}
		}

		return $human;
	}

	/**
	 * Read MIME of an uploaded file
	 */
	public function mime($file_code = '')
	{
		$file_code = \common\tools::sanitize($file_code);
		$file_mime_sql = "
SELECT
	file_mime mime
FROM query_uploads
WHERE
		file_code='{$file_code}'
;";
		if(!($mimes = $this->row($file_mime_sql)))
		{
			$mimes = array('mime' => 'n/a');
		}

		return $mimes['mime'];
	}
}
