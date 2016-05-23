<?php
namespace abstracts;

/**
 * CRON jobs activator
 *
 * @package Interfaces
 */
abstract class cronwork
{
	/**
	 * @todo Remove the use of the databases
	 */
	protected $db_parent = null;
	protected $db_child = null;

	protected $volume = 0;
	protected $seconds = 0;

	abstract public function __construct();
	abstract public function run($volume = 0, $seconds = 0);

	abstract public function __toString();

	abstract public function fix_records();

	abstract protected function operate_single_record($record_id = 0);
}
