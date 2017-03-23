<?php
namespace common;

/**
 * File comparing class - Written for students to practive writing exactly similar contents in a file.
 * Enforces common file patterns, source formatting and much more.
 *
 * @package Common
 */
class compare
{
	private $original; # Base file to compare
	private $compared; # Student's file to compare with the base

	/**
	 * Begin
	 */
	public function __construct($original_file = "", $compared_file = "")
	{
		$this->original = file_exists($original_file) ? $original_file : "";
		$this->compared = file_exists($compared_file) ? $compared_file : "";
	}

	public function compare_size()
	{
	}

	public function compare_total_lines()
	{
	}

	public function compare_each_lines()
	{
	}

	/**
	 * File size in Bytes
	 */
	public function file_size($whom = 'original')
	{
		return filesize($this->$whom);
	}

	/**
	 * Read out the number of lines in a file
	 */
	public function file_lines($whom = 'original')
	{
		$lines = count(file($this->$whom));

		return $lines;
	}

	/**
	 * Calculates a Hash of a file (MD5)
	 */
	public function file_hash($whom = 'original')
	{
		$hash = md5_file($this->$whom);

		return $hash;
	}

	/**
	 * Line by line, lists out the contents of a file
	 */
	public function line_by_line($whom = 'original', $compare_to = 'compared')
	{
		#$original_lines = file($this->$whom);
		#$compared_lines = file($this->$compare_to);

		$original_lines = preg_split('/[\r|\n]+/is', file_get_contents($this->$whom));
		$compared_lines = preg_split('/[\r|\n]+/is', file_get_contents($this->$compare_to));

		$lines = array();
		foreach($original_lines as $l => $line)
		{
			#if(!isset($compared_lines[$l]))
			{
				#break;
			}

			#echo("Matching: <strong>{$line}</strong> - <em>{$compared_lines[$l]}</em>");

			# Line by line comparision checker
			$matched_class = ($line == $compared_lines[$l]) ? 'Y' : 'N';

			#$line = wordwrap($line, 100, "\n");
			$line = substr($line, 0, 70);

			$line = htmlentities($line);
			#$lines[] = "<div class='{$matched_class}'>{$l}. {$line}</div>";
			$lines[] = "<li class='{$matched_class}'>{$line}</li>";
			#break;
		}

		return '<ol>' . implode("", $lines) . '</ol>';
	}
}

