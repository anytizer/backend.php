<?php
namespace \subdomain;


# Created on: 2011-02-10 00:27:11 536

/**
 * subdomains Class
 */

/**
 * Operations:
 *    $subdomains->add()
 *        Adds a new record in subdomains
 *    $subdomains->edit()
 *        Modified a record in subdomains
 *    $subdomains->delete()
 *        Removes one of subdomains record
 *    $subdomains->list_entries()
 *        Fetches a list of subdomains records
 *    $subdomains->details()
 *        Fetches the details of subdomains
 */
class subdomains
	extends \abstracts\entity
{
	/**
	 * Optional Constructor: Load on demand only.
	 */
	public function __construct()
	{
		# Parent's default constructor is necessary.
		parent::__construct();

		/**
		 * Set Private, Protected or Public Members
		 */
		$this->protection_code = '51338d0db553841cba867ea457535450'; # Some random text, valid for the entire life
		$this->table_name = 'query_subdomains'; # Name of this table/entity name
		$this->pk_column = 'subdomain_id'; # Primary Key's Column Name

		/**
		 * Validation fields as used in add/edit forms
		 */
		$this->fields = array(
			# Remove the columns that you do not want to use in the ADD form
			'add' => array(
				'subdomain_port' => null,
				'db_templates' => null,
				'template_file' => null,
				'subdomain_key' => null,
				'subdomain_prefix' => null,
				'subdomain_name' => null,
				'subdomain_short' => null,
				'subdomain_comments' => null,
				'subdomain_ip' => null,
				'dir_controllers' => null,
				'dir_templates' => null,
				'dir_configs' => null,
				'dir_plugins' => null,
				'subdomain_url' => null,
				'pointed_to' => null,
				'ftp_host' => null,
				'ftp_username' => null,
				'ftp_password' => null,
				'ftp_path' => null,
				'subdomain_description' => null,
			),

			# Remove the columns that you do not want to use in the EDIT form
			'edit' => array(
				'subdomain_port' => null,
				'db_templates' => null,
				'template_file' => null,
				'subdomain_key' => null,
				'subdomain_prefix' => null,
				'subdomain_name' => null,
				'subdomain_short' => null,
				'subdomain_comments' => null,
				'subdomain_ip' => null,
				'dir_controllers' => null,
				'dir_templates' => null,
				'dir_configs' => null,
				'dir_plugins' => null,
				'subdomain_url' => null,
				'pointed_to' => null,
				'ftp_host' => null,
				'ftp_username' => null,
				'ftp_password' => null,
				'ftp_path' => null,
				'subdomain_description' => null,
			),
		);
	}

	/**
	 * List entries from [ subdomains ]
	 * Column `code` signifies a protection code while deleting/editing a record
	 *
	 * @param $conditions SQL Conditions
	 *
	 * @return Multi-Dimensional array of entries in the list
	 */
	public function list_entries(\others\condition $condition, $from_index = 0, $per_page = 50)
	{
		$crud = new \backend\crud();

		/**
		 * Conditions are Compiled here so that we can manupulate them individually.
		 * And make them fit for [ subdomains ] only.
		 */
		$conditions_compiled_AND = $crud->compile_conditions(
			$condition->get_condition('AND'),
			false, 'AND', 1
		);
		$conditions_compiled_OR = $crud->compile_conditions(
			$condition->get_condition('OR'),
			false, 'OR', 2
		);

		$from_index = (int)$from_index;
		$per_page = (int)$per_page;
		$variable = new \common\variable(); # It may be necessary to read list out data of a user

		$listing_sql = "
SELECT SQL_CALC_FOUND_ROWS
	e.`subdomain_id`, # Do not remove this

	# Modify these columns to your own list(e.*)
	e.`subdomain_port`,
	e.`db_templates`,
	e.`template_file`,
	e.`subdomain_key`,
	e.`subdomain_prefix`,
	e.`subdomain_name`,
	e.`subdomain_short`,
	e.`subdomain_comments`,
	e.`subdomain_ip`,
	e.`dir_controllers`,
	e.`dir_templates`,
	e.`dir_configs`,
	e.`dir_plugins`,
	e.`subdomain_url`,
	e.`pointed_to`,
	e.`ftp_host`,
	e.`ftp_username`,
	e.`ftp_password`,
	e.`ftp_path`,

	e.`alias_id`,
	e.`is_live`,

	MD5(CONCAT(`subdomain_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_subdomains` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	# We assume that the sorting fields are available
	#`sink_weight` ASC,
	#`subdomain_id` DESC
	`subdomain_name` ASC
LIMIT {$from_index}, {$per_page}
;";
		$this->query($listing_sql);
		$entries = $this->to_array();

		# Pagination helper: Set the number of entries
		$counter_sql = "SELECT FOUND_ROWS() total;"; # Uses SQL_CALC_FOUND_ROWS from above query. So, run it immediately.
		$totals = $this->row($counter_sql);
		$this->total_entries_for_pagination = $totals['total'];

		return $entries;
	}

	/**
	 * Details of an entity in [ subdomains ] for management activities
	 *
	 * @param $pk integer Primary Key's value of an entity
	 *
	 * @return $details Associative Array of Detailed records of an entity
	 */
	public function details($subdomain_id = 0)
	{
		$subdomain_id = (int)$subdomain_id;
		$details_sql = "
SELECT
	e.`subdomain_id`, # Do not remove this

	e.*, # Modify these columns,

	# Admin must have it to EDIT the records
	MD5(CONCAT(`subdomain_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_subdomains` `e`
WHERE
	`subdomain_id` = {$subdomain_id}
;";
		$details = $this->row($details_sql);

		return $details;
	}

	/**
	 * Details of an entity in [ subdomains ] for public display.
	 *
	 * @param $pk integer Primary Key's value of an entity
	 *
	 * @return $details Associative Array of Detailed records of an entity
	 */
	public function get_details($subdomain_id = 0, $protection_code = "")
	{
		$protection_code = $this->sanitize($protection_code);
		$subdomain_id = (int)$subdomain_id;
		$details_sql = "
SELECT
	`subdomain_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`subdomain_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_subdomains` `e`
WHERE
	`subdomain_id` = {$subdomain_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`subdomain_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
		$details = $this->row($details_sql);

		return $details;
	}

	/**
	 * Flag is_live
	 */
	public function flag_hosts($subdomain_id = 0, $protection_code = "")
	{
		$protection_code = $this->sanitize($protection_code);
		$subdomain_id = (int)$subdomain_id;

		$flag_sql = "
UPDATE `query_subdomains` SET
	is_live=IF(is_live='Y', 'N', 'Y')
WHERE
	`subdomain_id` = {$subdomain_id}

	# Don't touch the deleted flags
	AND is_active='Y'
;";

		return $this->query($flag_sql);
	}

	/**
	 * Block actions: delete, disable, enable, prune, nothing
	 * Perform a certain action in a group of IDs. Extend only if you need them
	 */
	public function blockaction($action = 'nothing', $ids = array())
	{
		$ids = array_filter($ids, array(new \common\tools(), 'numeric_only'));
		if(!$ids)
		{
			# Filter that each IDs are numeric only
			return false;
		}

		switch($action)
		{
			case 'delete':
				# $this->blockaction_delete($ids);
				break;
			case 'disable':
				# $this->blockaction_disable($ids);
				break;
			case 'enable':
				# $this->blockaction_enable($ids);
				break;
			case 'prune':
				# $this->blockaction_prune($ids);
				break;
			case 'nothing':
			default:
				break;
		}

		return null;
	}


	/**
	 * Allow to operate on a particular record, with its protection code
	 */
	protected function allow_protected_action($subdomain_id = 0, $protection_code = "")
	{
		# Action is: edit:update / delete:inactivate
		$subdomain_id = (int)$subdomain_id;
		$protection_code = $this->sanitize($protection_code);
		$test_allow_action_sql = "
SELECT
	(COUNT(`subdomain_id`) = 1) `allow`
FROM `query_subdomains` `e`
WHERE
	`subdomain_id` = {$subdomain_id}

	# This is NOT optional: Must Pass
	AND MD5(CONCAT(`subdomain_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
		$permission = $this->row($test_allow_action_sql);

		return $permission['allow'];
	}

	/**
	 * Installs a subdomain
	 */
	function install_subdomain($subdomain_id = 0)
	{
		$subdomain_id = (int)$subdomain_id;
		if($subdomain_id)
		{
			# index page
			# login page
			# logout page
			# config page
			# templates
			# controllers
			# plugins
			# sqls
			# smarty config directory
			# JS
			# CSS
			# Images

			if($subdomain = $this->details($subdomain_id, ""))
			{
				# We have just found the sufficient subdomain details
			}
			else
			{
				\common\stopper::message('Invalid Subdomain ID rquest for installation.');
			}

			$framework = new \backend\framework();
			$__SUBDOMAIN_BASE__ = $framework->subdomain_base($subdomain_id, $expected = true);

			$directories = array(
				# Main base
				$__SUBDOMAIN_BASE__,

				# Base dependents
				$__SUBDOMAIN_BASE__ . '/classes',
				$__SUBDOMAIN_BASE__ . '/configs',
				$__SUBDOMAIN_BASE__ . '/controllers/',
				$__SUBDOMAIN_BASE__ . '/plugins',
				$__SUBDOMAIN_BASE__ . '/sqls',
				$__SUBDOMAIN_BASE__ . '/templates',
				$__SUBDOMAIN_BASE__ . '/developers',

				# Re-written interactives (CURDER will write these files again)
				$__SUBDOMAIN_BASE__ . '/templates/images',
				$__SUBDOMAIN_BASE__ . '/templates/css',
				$__SUBDOMAIN_BASE__ . '/js',
				$__SUBDOMAIN_BASE__ . '/js/validators',

				# Customizable templates are read from here.
				# If not, from the parent distribution.
				#$__SUBDOMAIN_BASE__.'/js/cruder-templates',
				#$__SUBDOMAIN_BASE__.'/js/cruder-templates/css',

				# The basic CRUDer templates
				$__SUBDOMAIN_BASE__ . '/cruder',
			);

			# Create the necessary directories
			# array_map('mkdir', $directories);
			foreach($directories as $directory)
			{
				# Forces to recursively make the deepest level directories.
				@mkdir($directory, 0777, true);
			}

			$subdomain_key = \common\tools::random_text(10);
			$install_subdomain_sql = "
UPDATE query_subdomains SET
	begun_on = CURRENT_TIMESTAMP(),
	subdomain_key='{$subdomain_key}',
	is_active='Y',
	is_down = 'N',
	is_installed='Y'
WHERE
	subdomain_id={$subdomain_id}
;";
			$this->query($install_subdomain_sql);

			# Add these 3 default pages.
			# index.php, login.php, logout.php
			$install_default_pages = "
INSERT IGNORE INTO query_pages
(subdomain_id, page_name, is_active, needs_login, content_title, content_text) VALUES
({$subdomain_id}, 'index.php', 'Y', 'N', 'Introduction', 'Welcome to our home page.'),

# Login needs a login.php template, not supplied now.
({$subdomain_id}, 'index.php', 'Y', 'N', 'Home', 'Welcome.'),
({$subdomain_id}, 'login.php', 'Y', 'N', 'Login', 'Please authenticate yourself.'),
({$subdomain_id}, 'logout.php', 'Y', 'N', 'Logout', 'Taking you out of secured zones.')
;";

			# Assumes success only
			return true;
		}

		return $subdomain_id;
	}


	/**
	 * Uninstalls a subdomain. Physical files are NOT removed.
	 */
	function uninstall_subdomain($subdomain_id = 0)
	{
		$subdomain_id = (int)$subdomain_id;
		$uninstall_subdomain_sql = "
UPDATE query_subdomains SET
	shutdown_on = CURRENT_TIMESTAMP(),

	# If this flag is Y and shutdown_on has a stamp,
	# it means, was reactivated in this time.
	is_down = IF(is_down='Y', 'N', 'Y')
WHERE
	subdomain_id={$subdomain_id}

	# Disallow shutting down the parent framework
	AND subdomain_name!='{$_SERVER['SERVER_NAME']}'
;";
		$this->query($uninstall_subdomain_sql);

		return $subdomain_id;
	}

	/**
	 * Creates an alias of a subdomain by registering it.
	 */
	public function alias($subdomain_id = 0, $alias_id = 0)
	{
		$subdomain_id = (int)$subdomain_id;
		$alias_id = (int)$alias_id;

		$alias_sql = "
UPDATE query_subdomains SET
	alias_id = {$alias_id}
WHERE
	subdomain_id={$subdomain_id}

	# Disallow registering current framework to anyone else.
	# Only the framework executes here.
	# Otherwise, it will immediately misbehave.
	AND subdomain_name!='{$_SERVER['SERVER_NAME']}'
;";
		$this->query($alias_sql);

		# We expect only one change, and thats for sure.
		return 1 == $this->affected_rows();
	}

	/**
	 * Finds the current alias of a subdomain.
	 */
	public function alias_current($subdomain_id = 0)
	{
		$subdomain_id = (int)$subdomain_id;
		$current_subdomain_sql = "
SELECT
	subdomain_id,
	alias_id
FROM query_subdomains
WHERE
	subdomain_id={$subdomain_id};
;";
		$subdomains = $this->row($current_subdomain_sql);
		$subdomains['alias_id'] = isset($subdomains['alias_id']) ? $subdomains['alias_id'] : 0;

		return $subdomains['alias_id'];
	}

	/**
	 * Finds the ID of current subdomain.
	 * Primarily used in debugging on 404 error pages.
	 */
	public function current_subdomain()
	{
		$current_subdomain_sql = "
SELECT
	subdomain_id,
	alias_id
FROM query_subdomains
WHERE
	# Read the current server name
	subdomain_name='{$_SERVER['SERVER_NAME']}'
;";
		$subdomains = $this->row($current_subdomain_sql);
		$subdomains['subdomain_id'] = isset($subdomains['subdomain_id']) ? $subdomains['subdomain_id'] : 'N/A';
		$subdomains['alias_id'] = isset($subdomains['alias_id']) ? $subdomains['alias_id'] : 'N/A';

		/**
		 * @todo It may not have been used
		 */
		return "[{$subdomains['subdomain_id']} =&gt; {$subdomains['alias_id']}]";
	}

	/**
	 * Locates where the current subdomain is at.
	 */
	public function base($subdomain_id = 0)
	{
		$framework = new \backend\framework();

		return $framework->subdomain_base($subdomain_id);
	}

	/**
	 * List of candidate hosts for updating the hosts file
	 */
	public function get_hosts()
	{
		$hosts_sql = "
SELECT
	qs.subdomain_id `id`,

	#IF(qs.is_live='Y' AND qs.is_active='Y', 'Y', 'N') `hosts`,
	# Though the hosts are NOT active, we might have pointing IPs defined.
	# So, disregarding the is_active flag.
	qs.is_live `hosts`,

	LOWER(qs.subdomain_name) `name`,
	qs.subdomain_comments `comments`
FROM query_subdomains qs
HAVING
	`name` NOT IN('localhost', 'ALL')

	# Avoid the current framework server, we will force it to be local
	AND `name` NOT IN ('{$_SERVER['SERVER_NAME']}')
ORDER BY
	qs.subdomain_name
;";
		$hosts = $this->arrays($hosts_sql);

		return $hosts;
	}

	/**
	 * Update the number of pages in each subdomain.
	 * Access is private only - cache clearing script.
	 */
	public function update_pages_counter()
	{
		$list_pages_sql = "
SELECT
	qs.subdomain_id,
	COUNT(qp.page_id) pages
FROM query_pages qp
INNER JOIN query_subdomains qs ON
	qs.subdomain_id = qp.subdomain_id
GROUP BY
	qs.subdomain_id
;";
		$this->query($list_pages_sql);

		$db = new \common\mysql();
		while($sp = $this->row(""))
		{
			$update_sql = "
UPDATE query_subdomains SET
	pages_counter={$sp['pages']}
WHERE
	subdomain_id={$sp['subdomain_id']}
;";
			$db->query($update_sql);
		}
	}
}
