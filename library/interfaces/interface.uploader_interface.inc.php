<?php
namespace interfaces;

/**
 * An interface to upload the files individually after building the data
 *
 * @package Interfaces
 */
interface uploader_interface
{
	/**
	 * Move the file to its destination.
	 */
	public function upload($extension = '.xxx');

	# Determine the file name being saved to
	# public function filename();

	/**
	 * Patch the database once the file is just uploaded
	 *
	 * @param string $filename Name of the file that was just uploaded.
	 * @param int $record_id Primary key according with a data is being modified.
	 * @param array $params
	 *
	 * @return mixed
	 *
	 * @todo $parameters can be declared as array $parameters
	 */
	public function patch($filename = 'YYYYMMDDHHIISSXXXX', $record_id = 0, $params = array());
}
