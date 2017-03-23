<?php
namespace backend;

/**
 * Removes orphan files from some directories on the server
 */
class files_remover
	extends \common\mysql
{
	private $setup = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function remove_files($path = '/tmp', $table = "", $column = "")
	{
		if(!is_dir($path))
		{
			return;
		}

		$this->setup[] = array(
			'path' => realpath($path),
			'table' => $table,
			'column' => $column,
		);
	}

	/**
	 * Tests if the image reocrd is available in the database.
	 */
	private function is_valid_file($fullpath = '/tmp', $table = "", $column = "")
	{
		$filename = basename($fullpath);
		$match_sql = "SELECT {$column} FROM {$table} WHERE $column='{$filename}';";
		$is_matched = $this->row($match_sql);

		return isset($is_matched[$column]);
	}

	public function __destruct()
	{
		foreach($this->setup as $s => $setup)
		{
			$glob = "{$setup['path']}/*";
			$files = glob($glob);

			foreach($files as $f => $file)
			{
				$filaname = basename($file);
				if(!$this->is_valid_file($file, $setup['table'], $setup['column']))
				{
					# Find out if files are valid to remove or not.
					if(!preg_match('/[\d]{18,}/', $file))
					{
						continue;
					}
					#if(!preg_match('/^[\d]{18,}\.?(jpg|gif|png)?$/', $file)) continue;
					#echo "\r\nDELETING: {$file}";

					echo "\r\nunlink('{$file}');";
				}
				else
				{
					echo "\r\n#SAFE: {$file}";
				}
			}
		}
	}
}

