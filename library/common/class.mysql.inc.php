<?php
namespace common;

/**
 * MySQL basic class
 *
 * @package Databases
 * @uses __TEMP_PATH__
 * @uses __APP_PATH__
 *
 * Change Log
 * - Basic Conversion to MySQLi
 *
 * @todo Convert MySQLi Object Oriented Way
 */
class mysql
{
	/**
	 * @var integer Number of rows affected by last {@link function query} attempt.
	 */
	public $ROWS = 0;

	/**
	 * @var array List of columns retrieved on the last {@link query} attempt.
	 */
	public $FIELDS = array();

	/**
	 * @var integer Number columns retrieved on the last {@link query} attempt.
	 */
	public $FIELDS_COUNTER = 0;

	/**
	 * @var array Association of columns and values of one row.
	 * @see mysql::next_record()
	 */
	public $row_data;

	/**
	 * @var object Metadata of each columns ({@link FIELDS}) retrieved.
	 */
	protected $META_DATA;

	/**
	 * @var RESOURCE Database resultset
	 */
	protected $RESULTSET;

	/**
	 * @var RESOURCE MySQL connection resource
	 */
	protected $CONNECTION;

	/**
	 * Allows to update meta or not. Boolean
	 */
	protected $UPDATE_META = true;

	/**
	 * Constructor
	 * <br>Connects to the database with the assigned server details.
	 * <br>Reuses the connection resources if possible.
	 */
	public function __construct()
	{
		global $MYSQL_CONNECTION;

		/**
		 * Guarantees single connection to mysql by using a globally available connection, if connected already.
		 */
		if(empty($MYSQL_CONNECTION))
		{
			$myself = dirname(__FILE__);

			/**
			 * All possible configuration files
			 */
			$lookups = array(# Attempt from the reservoir.
				__APP_PATH__ . '/database/config.mysql.inc.php',
				#$myself . '/config.mysql.inc.php',
			);
			#print_r($lookups);

			/**
			 * Get the first configuration files that exist
			 */
			$lookups = array_filter(array_map('realpath', $lookups));
			#print_r($lookups);

			$looked_up = false;
			foreach($lookups as $l => $configuration_file)
			{
				require_once($configuration_file);
				$looked_up = true;
				break;
			}
			if($looked_up != true)
			{
				throw new \Exception('Could not find mysql configuration file.');
			}

			#print_r($MYSQL_CONNECTION); die('That was done...');
			if(!is_object($MYSQL_CONNECTION)) # is_resource
			{
				/**
				 * We are just expecting some best thing to happen within the mysql configuration file.
				 * Anyway, let us just test if everything is ok.
				 */
				throw new \Exception('MySQL connection was not defined in the configuration file.');
			}
		}
		$this->CONNECTION = $MYSQL_CONNECTION;
	}

	/**
	 * Returns the values of a selected fields into an array.
	 * Considers only the values :-), not the keys and column names.
	 * Similar to to_association() / to_array()
	 * Assumes,    $this->query($sql); was called just earlier than this.
	 *
	 * @param string $column
	 * @param string $sql
	 *
	 * @return array
	 */
	public function values($column = "", $sql = "")
	{
		if($sql)
		{
			$this->query($sql);
		}

		$values = array();
		if(in_array($column, $this->FIELDS))
		{
			while($this->next_record())
			{
				#if(isset($this->row_data[$column]))
				{
					$values[] = $this->row_data[$column];
				}
			}
		}

		return $values;
	}

	/**
	 * Attempt to run almost any kind of database queries
	 *
	 * @var string $sql Valid SQL to hit
	 * @return boolean Success / Failure  status while making a query
	 */
	public function query($sql = "")
	{
		$success = false;
		if($sql == "" || $sql == '#')
		{
			debug_print_backtrace();
			\common\stopper::message('Empty query was passed in.', false);

			/**
			 * @todo Rather use \Exception
			 */

			return $success;
		}

		/**
		 * Disable this line to speed up
		 * Run in debug only, or for silent monitoring purpose
		 */
		$this->_log_query($sql);

		$this->__RESET_VARIABLES(); # start as a fresh; always!

		if($this->RESULTSET = mysqli_query($this->CONNECTION, $sql)) #  or \common\stopper::message(mysqli_error($this->CONNECTION).' -- '.$sql))
		{
			/**
			if($this->UPDATE_META)
			{
				/**
				 * Take care of sanitized sql only
				 * Throw all the comments first
				 * Inspired by WordPress's db wrapper
				 * But these features can kill the server resources
				 * /
				if(preg_match("/^\\s*(INSERT|DELETE|UPDATE|REPLACE|ALTER|TRUNCATE) /is", $sql))
				{
					$this->ROWS = mysqli_affected_rows($this->CONNECTION) + 0;

					# Take note of the insert_id
					#if(preg_match("/^\\s*(INSERT|REPLACE) /i", $sql))
					#{
					#	$this->insert_id = mysqli_insert_id($this->CONNECTION);
					#}
				}
				else
				{
					#echo($sql);
					#$this->FIELDS_COUNTER = !(preg_match("/(CREATE|DROP|TRUNCATE|INSERT)/is", $sql))?mysqli_num_fields($this->RESULTSET)+0:0;
					#$this->FIELDS_COUNTER = (preg_match("/\\s*(SELECT|UPDATE)/is", $sql))?mysqli_num_fields($this->RESULTSET)+0:0;
					$this->FIELDS_COUNTER = mysqli_num_fields($this->RESULTSET) + 0;
					for($i = 0; $i < $this->FIELDS_COUNTER; ++$i)
					{
						if($meta = mysqli_fetch_field($this->RESULTSET))
						{
							$this->FIELDS[] = $meta->name;
							$this->META_DATA[$meta->name] = $meta;
						}
					}
				}
			}
			*/
			$success = true;
			#\common\stopper::debug($this, true);
		}
		else
		{
			$success = false;
			# Show the error only in the local computer for debug.
			# \common\stopper::debug("<strong style='color:#ff0000;'>SQL Error!</strong> {$sql}<hr />".mysqli_error($this->CONNECTION), true);
			\common\stopper::record('mysql-failed.log', $sql . ' -- ' . mysqli_error($this->CONNECTION));
			#$this->_log_query($sql);
		}

		#\common\stopper::debug($this, true);
		return $success;
	}

	/**
	 * Seek one record, if available.
	 * <br>Sets an association of the database columns and values selected.
	 *
	 * @return boolean Was seeking to next record possible?
	 */
	public function next_record()
	{
		$success = true;
		if(is_bool($this->RESULTSET))
		{
			$this->row_data = array();

			return false;
		} # Resultset should be a resource.
		if(!$this->RESULTSET)
		{
			$this->row_data = array();

			return false;
		}
		#if(mysqli_num_rows($this->RESULTSET))
		{
			$row_data = mysqli_fetch_assoc($this->RESULTSET) or $success = false;
			if(is_array($row_data) && $success === true)
			{
				$this->row_data = $row_data;
			}
		}
		#else
		{
			#$success=false;
		}

		return $success;
	}

	/**
	 * Log what query was operated when?
	 * Logs queries by Daily Hours/Minute stamp, appending into a common file.
	 * This makes the debug easier, within the temp/sql directory list.
	 */
	private function _log_query($sql = "")
	{
		static $counter = 0;
		++$counter;

		$date_stamp = @date('Y-m-d');
		$DATETIME_stamp = @date('Y-m-d H:i:s');
		$file = __TEMP_PATH__ . "/{$_SERVER['SERVER_NAME']}/{$date_stamp}.sql";
		$log_message = "

-- {$counter}: {$DATETIME_stamp}@{$_SERVER['REMOTE_ADDR']} {$_SERVER['REQUEST_URI']}
{$sql}";
		file_put_contents($file, $log_message, FILE_APPEND);

		return false;
	}

	/**
	 * Reset all the internal variables to null.
	 *
	 * @access private
	 */
	private function __RESET_VARIABLES()
	{
		$this->ROWS = 0;
		$this->FIELDS = array();
		$this->FIELDS_COUNTER = 0;
		$this->META_DATA = array();
		$this->row_data = array();
	}

	/**
	 * Move the query result into an array
	 * Constraint - a query should have been done already!
	 *
	 * @param bool $nested_array
	 *
	 * @return array Array of the query result.
	 */
	public function to_array($nested_array = true)
	{
		$array = array();
		while($this->next_record())
		{
			$array[] = ($this->FIELDS_COUNTER == 1 && $nested_array == false) ? $this->row_data[$this->FIELDS[0]] : $this->row_data;
		}

		return $array;
	}

	/**
	 * Similar to to_array(), but with specified column head.
	 * Warning: The column name must have unique values to prevent overwrting.
	 *
	 * @todo This is probably a deprecated way.
	 */
	public function &lead_unique($column_name = "")
	{
		$array = array();
		while($this->next_record())
		{
			if(!empty($this->row_data[$column_name]))
			{
				$array [$this->row_data[$column_name]] = $this->row_data;
			}
		}

		return $array;
	}

	/**
	 * Similar to to_array(), but with specified column head.
	 * Warning: Categorises each array with a lead column.
	 *
	 * @todo This is probably a deprecated way.
	 */
	public function &lead($column_name = "")
	{
		$array = array();
		while($this->next_record())
		{
			if(!empty($this->row_data[$column_name]))
			{
				$array [$this->row_data[$column_name]][] = $this->row_data; # This line differs!
			}
		}

		return $array;
	}

	/**
	 * Move the query result into an associative array.
	 * Suggestion: SELECT ONLY TWO COLUMNS ONLY!
	 * Constraint - a query should have been done already!
	 *
	 * @param string $index_column
	 * @param string $value_column
	 *
	 * @return array Associative array of indices and vlaues.
	 */
	public function to_association($index_column = "", $value_column = "")
	{
		$index_column = trim($index_column);
		$value_column = trim($value_column);
		if(empty($index_column) || empty($value_column))
		{
			echo('Empty index or value column to create an association');

			return array();
		}

		$array = array();
		while($this->next_record())
		{
			/**
			 * This is poor way, because we are already inside a loop.
			 * However, it will prevent a user receiving error messages.
			 * Performance issues will be another part, we won't draw much data per loop.
			 */
			#if(isset($this->row_data[$value_column]))
			{
				$array[$this->row_data[$index_column]] = $this->row_data[$value_column];
			}
			#else
			{
				# Rather this, raise some error notifications
				#$array[$this->row_data[$index_column]]="";
			}
		}

		return $array;
	}

	/**
	 * Extract only one column in an array!
	 * If value repeats, array will contain repeated value in its own.
	 * Similar to TO_ARRAY() but takes only one column instead of all columns available
	 */
	public function to_columnar_array($index_column = "")
	{
		$RESULTSET = $this->RESULTSET; # Backup, for safety
		$array = array();
		while($this->next_record())
		{
			$array[] = $this->row_data[$index_column];
		}
		$this->RESULTSET = $RESULTSET; # restore
		return $array;
	}

	/**
	 * Find a row out of a query data generated.
	 * Recommended to use a query resulting only one row.
	 */
	public function count_records($sql = "")
	{
		$row = array();

		$totals = array();

		/**
		 * Case sensitive matching only!
		 * Theme: Disable DELETE, UPDATE
		 */
		preg_match_all('/^[\ \n\r\t]*?SELECT(.*?)FROM(.*?)WHERE(.*?);$/s', $sql, $totals, PREG_PATTERN_ORDER);
		if(!count($totals[0]))
		{
			\common\stopper::debug("<pre>You can not make this function call: <strong>row()</strong> for the invalid SELECT operation in: <em>{$sql}</em></pre>", true);
		}

		if($RESULTSET = mysqli_query($this->CONNECTION, $sql))
		{
			$row = mysqli_fetch_array($RESULTSET, MYSQLI_ASSOC);
		}

		return $row;
	}

	/**
	 * Lists out tables within the currently connected database
	 */
	public function tables()
	{
		$tables = array();
		$tables_sql = 'SHOW TABLES FROM `' . MYSQL_DATABASENAME . '`;';
		$tables_list = $this->arrays($tables_sql);
		foreach($tables_list as $t => $table)
		{
			$columns = array_values($table); # Avoid the rush of unknown databases.
			$tables[] = $columns[0];
		}

		return $tables;
	}

	/**
	 * Gives the to_array() result directly from SQL.
	 */
	public function arrays($sql_full_string = "")
	{
		$this->toggle_update_meta(false);

		$array = array();
		if(!empty($sql_full_string)) # By mistake, SQL can be empty
		{
			$this->query($sql_full_string);
			while($this->next_record())
			{
				$array[] = $this->row_data;
			}
		}
		$this->toggle_update_meta(); # Leave it as original
		return $array;
	}

	/**
	 * Toggles when to update the meta
	 */
	public function toggle_update_meta($open_meta = true)
	{
		/**
		 * Plans: allow to toggle to true/false by the parameter flag.
		 * TRIPLE equals check here
		 */
		if($open_meta === true)
		{
			$this->UPDATE_META = true;
		}
		else
		{
			$this->UPDATE_META = !($this->UPDATE_META === true);
		}
	}

	/**
	 * Convert a table name's id into its value, based on its primary key
	 */
	public function get_table_value($table = "", $column_name = "", $primary_key = "", $pk_id = 0, $is_unsafe = true)
	{
		/**
		 * When considering unsafe entries, make them integers by adding zero.
		 * For safe columns, pass it as <false> to keep as it is. Especially, working with unique keys and varchar type columns.
		 */
		if($is_unsafe === true)
		{
			$pk_id += 0;
		}

		$sql = "
SELECT
	`{$column_name}` `v`
FROM `{$table}` `t`
WHERE
	`t`.`{$primary_key}`='{$pk_id}' # Quoted? Case Based.
;";
		$value = $this->row($sql);
		if(!isset($value['v']))
		{
			$value = array('v' => null);
		}

		return $value['v'];
	}

	/**
	 * Get a first record of a query
	 *
	 * @var $sql string; if missing, loops through itself.
	 * @return array
	 */
	public function row($sql = '#')
	{
		$row = array();
		/**
		 * Once, loop through the result set and send the first data out. Assumes that the query was just performed.
		 * Otherwise, it will err with empty query isseues.
		 */
		if($sql)
		{
			$this->query($sql);
		}
		if($this->next_record())
		{
			#echo $sql;
			$row = $this->row_data;
			#print_r($this);
		}


		return $row;
	}

	/**
	 * Terminates any existing connections and data.
	 */
	public function __destruct()
	{
		/**
		 * Gives a problem, with [session] class and other inherited class:
		 * if the following code executes.
		 * So, leave as it is.
		 */
		#mysqli_free_result($this->RESULTSET);
		#if($this->CONNECTION)
		{
			#mysqli_close($this->CONNECTION);
		}
	}

	/**
	 * Lists out all columns in a table
	 */
	public function columns($table = "")
	{
		$this->META_DATA = array(); # Reset it

		#$this->query("SELECT * FROM `{$table}` LIMIT 1;");
		#$columns = array_keys($this->META_DATA);

		$columns = array();
		$results = $this->arrays("SHOW COLUMNS FROM `{$table}`;");
		if($results)
		{
			foreach($results as $r => $result)
			{
				$columns[] = $result['Field'];
			}
			/*
			Array
			(
				[Field] => article_id
				[Type] => int(10) unsigned
				[Null] => NO
				[Key] => PRI
				[Default] =>
				[Extra] => auto_increment
			)
			*/
		}

		return $columns;
	}


	/**
	 * Functions of public interests
	 */

	/**
	 * Tries to get last insert ID.
	 */
	public function insert_id()
	{
		$last_insert_id = mysqli_insert_id($this->CONNECTION);

		return $last_insert_id;
	}

	/**
	 * Tries to send information about number of affected rows
	 * as a result of last query made.
	 */
	public function affected_rows()
	{
		$affected_rows = mysqli_affected_rows($this->CONNECTION);

		return $affected_rows;
	}

	/**
	 * HTML <option>...</option> generation
	 * Usage domain - primarily for quick ajax-ing
	 * is_array: true: Returns array
	 *    false: returns html part
	 */
	public function options($key_column = "", $value_column = "", $is_array = false, $print_first_empty = false)
	{
		$options = array();
		if($print_first_empty === true)
		{
			# Implied to ensure that javascript on-change handlers may work, if apllied.
			$options[] = '<option value="">-- choose --</option>';
		}

		while($this->next_record())
		{
			$options[] = "<option value=\"{$this->row_data[$key_column]}\">{$this->row_data[$value_column]}</option>";
		}

		if($is_array === true)
		{
			return $options;
		}
		else
		{
			return implode("", $options);
		}
	}

	/**
	 * Switch to a new database
	 *
	 * @param string $database
	 *
	 * @return bool
	 */
	public function database($database = 'test')
	{
		return mysqli_select_db($this->CONNECTION, $database);
	}
} # class mysql
