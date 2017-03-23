<?php
namespace common;

/**
 * FTP connections and uploads
 */
class ftp
{
	private $connection = null;
	private $login = null;

	/**
	 * @todo Fix the class file
	 */
	public function __construct()
	{
	}
	

	public function connect($ftp_server = "")
	{
		$success = true;
		$this->connection = ftp_connect($ftp_server) or $success = false;
		# ("Could not connect to server: {$ftp_server}");
		ftp_pasv($this->connection, false); # Be sure, it may be server specific
		ftp_set_option($this->connection, FTP_TIMEOUT_SEC, 5);
		#ftp_set_option($this->connection, FTP_BINARY, true); # Unsupported, currently.

		# Go to the default home directory supplied in the parameter
		#ftp_chdir($this->connection, "~");
		
		return $success;
	}

	public function login($ftp_user_name = "", $ftp_user_pass = "")
	{
		$this->login = ftp_login($this->connection, $ftp_user_name, $ftp_user_pass) or die('Could not login');

		$success = $this->connection && $this->login;
		return $success;
	}

	/**
	 * Login via direct URL.
	 * All the connection parameters (eg. username, password, directory to login to etc.) are already supplied.
	 */
	public function login_direct($url = "")
	{
		#$url = 'ftp://username:password@hostnameorip/fol/der';
		#$url = 'ftp://username:password@hostnameorip';
		$pattern = '#(.*?)://(.*?):(.*?)@([a-z0-9\.\-\_]+)/?(.*?)$#is';
		$data = array();
		preg_match($pattern, $url, $data);
		print_r($data);
		die();

		# Concepts:
		# Find parameters
		# Login
		# Change the directory specified
	}

	public function upload($destination_file = "", $source_file = "")
	{
		#echo "\r\nftp_put({$this->connection}, {$destination_file}, {$source_file}, FTP_BINARY);";
		#die('Directory: '.dirname($destination_file));
		#ftp_chdir($this->connection, dirname($destination_file));
		#ftp_put($this->connection, basename($destination_file), $source_file, FTP_BINARY);

		return ftp_put($this->connection, $destination_file, $source_file, FTP_BINARY);
	}

	/**
	 * Go the the default/home directory
	 */
	public function change_directory($directory = '/')
	{
		return ftp_chdir($this->connection, $directory);
	}

	/**
	 * Recursively make directory on the FTP server
	 *
	 * @return boolean Success flag
	 */
	public function make_directory($path = "")
	{
		$path = "";
		$success = true;
		$directory = explode('/', $path);

		for($i = 0; $i < count($dir); ++$i)
		{
			$path .= '/' . $directory[$i];
			echo "{$path}\n";
			continue;
			ftp_mkdir($this->connection, $path);
			#if(!@ftp_mkdir($this->connection, $path))
			#{
			#	$success=false;
			#	break;
			#}
		}

		return $success;
	}

	/**
	 * Upload all files from local repo to FTP server
	 * Recursive upload, creates directories on the FTP server.
	 *
	 * @todo Not yet completed.
	 */
	public function mirror($local_directory = '/', $remote_directory = '/')
	{
		$recursive = __METHOD__;
		# Recurse through the local directory.
		# Create a directory, if not existing on the server
		# upload the files and sub directories

		# From PHP User Manual: http://php.net/manual/en/function.ftp-put.php
		# function ftp_putAll($src_dir, $dst_dir) {
		$src_dir = $local_directory;
		$dst_dir = $remote_directory;

		$d = dir($src_dir);
		while($file = $d->read()) # do this for each file in the directory
		{
			if($file != '.' && $file != '..') # to prevent an infinite loop
			{
				if(is_dir($src_dir . '/' . $file)) # do the following if it is a directory
				{
					if(!@ftp_nlist($conn_id, $dst_dir . '/' . $file))
					{
						# create directories that do not yet exist
						ftp_mkdir($dst_dir . '/' . $file);
					}

					# recursive part
					$this->$recursive($conn_id, $src_dir . '/' . $file, $dst_dir . '/' . $file);
				}
				else
				{
					# put the files
					$upload = ftp_put($conn_id, $dst_dir . '/' . $file, $src_dir . '/' . $file, FTP_BINARY);
				}
			}
		}
		$d->close();
	}

	/**
	 * Close the FTP session.
	 */
	public function __destruct()
	{
		ftp_close($this->connection);
	}
}

