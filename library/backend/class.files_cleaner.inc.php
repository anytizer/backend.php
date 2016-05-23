<?php
namespace backend;

/**
 * Cleans up old files of selected extension and age of creation (in seconds).
 * Warning: If used wrongly, it will erase everything, without a chance of recovery.
 *
 * @author Bimal Poudel
 * Example of usage:
 *    $lookup_dir = './'; # Where to look for files to delete?
 *    $extension = 'xml'; # Remove this kind of file
 *    $acceptable_age = 50; # in seconds; will remove files created before 100 seconds
 *    $cleaner = new files_cleaner($lookup_dir, $extension, $acceptable_age);
 *    $files_removed = $cleaner->files_removed();
 *    $files_listed  = $cleaner->files_listed();
 *    echo "Removed {$files_removed} file(s). Waiting {$files_listed} file(s).";
 */
class files_cleaner
{
	private $files_removed;
	private $files_listed;

	public function __construct($lookup_dir = '/tmp', $extension = 'cache', $acceptable_age = 1000000)
	{
		if(!is_dir($lookup_dir))
		{
			# Why to bother opening the directory when we cannot access it?
			return;
		}

		$acceptable_age = (int)$acceptable_age;
		$extension = preg_replace('/[^a-z]/i', '', $extension); # use lower-case alphabetic extensions only

		# Reset the counters
		$this->files_removed = 0;
		$this->files_listed = 0;

		# while processing a big list of files, it will give same time
		$time = time();

		if($handle = opendir($lookup_dir))
		{
			while(false !== ($file = readdir($handle)))
			{
				$file = str_replace('//', '/', $lookup_dir . '/' . $file); # The absolute file

				if(!is_file($file))
				{
					# It should be a regular file only
					continue;
				}

				if(!preg_match('/\.' . $extension . '$/', $file))
				{
					# Use your own extensions in the parameters correctly
					continue;
				}

				$diff = ($time - filectime($file));
				if($diff > $acceptable_age)
				{
					# Physically remove the file and count the number
					# It is always risky to unlink files.
					$this->removed_files += (int)unlink($file);
				}
				else
				{
					++$this->files_listed;
				}
			}
			closedir($handle);
		}
	}

	public function files_removed()
	{
		# Total number of files remvoed successfully
		return $this->files_removed;
	}

	public function files_listed()
	{
		# Matched, but not deleted files
		# Reason: age was not sufficiently older to delete
		return $this->files_listed;
	}
}

