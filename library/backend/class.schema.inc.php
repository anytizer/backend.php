<?php
namespace backend;
use \common\mysql;

/**
 * MySQL schema class dealing with information schema
 *
 * @package Databases
 */
class schema
    extends mysql
{
    private $database = 'information_schema';

    /**
     * @todo Fix this class file
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function database($database = "")
    {
        if (!$database) {
            throw new \Exception('Missing database name in the Schema');
        }
        $this->database = $database;
    }

    /**
     * Tries to find out the primary key of a table.
     * Looks up into the schema table.
     * This can be a very slow process. So do not run in the loop, without knowledge.
     *
     * @link http://codeherb.com/find_primary_keys_sql/
     */
    public function primary_key($table = "")
    {
        $find_primary_key_sql = "
SELECT
	t.column_name
FROM information_schema.TABLE_CONSTRAINTS c 
INNER JOIN information_schema.KEY_COLUMN_USAGE t
USING (constraint_name, table_schema, table_name)
WHERE
	c.constraint_type='PRIMARY KEY'
	AND c.table_schema='{$this->database}'
	AND c.table_name='{$table}'
;";
        $columns = $this->row($find_primary_key_sql);
        if (!isset($columns['column_name'])) {
            $columns = array('column_name' => 'PRIMARY_KEY');
        }

        return $columns['column_name'];
    }

    /**
     * Finds out the column comment on a particular database
     */
    public function column_comments($table = "", $column = "")
    {
        $column_comment_sql = "
SELECT
	COLUMN_COMMENT
FROM information_schema.COLUMNS
WHERE
	TABLE_SCHEMA='{$this->database}'
	AND TABLE_NAME='{$table}'
	AND COLUMN_NAME='{$column}'
;";
        $column = $this->row($column_comment_sql);
        if (!isset($column['COLUMN_COMMENT'])) {
            $column = array('COLUMN_COMMENT' => "");
        }

        return $column['COLUMN_COMMENT'];
    }
} # class mysql