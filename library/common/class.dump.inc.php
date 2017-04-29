<?php
namespace common;

/**
 * Database Dumper Class
 * @todo Check if still in use
 *
 * @package Databases
 */
class dump
{
    public $db0;
    public $db1;
    public $tables;
    public $database = 'test';

    /**
     * @param string $database
     */

    function __construct($database = 'test')
    {
        $this->database = $database;

        $this->db0 = new \common\mysql();
        $this->db1 = new \common\mysql();

        $this->build_tables();
    }

        /**
     * Build Tables
     */
    function build_tables()
    {
        $this->tables = array();
        $tables_sql = "SHOW tables;";
        $this->db0->query($tables_sql);
        while ($this->db0->next_record()) {
            #if(is_array($dumper))
            #{
            #if(!in_array($this->db0->row_data['Tables_in_'.$this->database], $dumper))
            #continue;
            #}
            $this->tables[] = $this->db0->row_data['Tables_in_' . $this->database];
        }
    } # fix_quotation

/**
     * Create a list of tables
     *
     * @return mixed|string
     */
    function create_tables()
    {
        $real_create_table = "";
        foreach ($this->tables as $key => $table) {
            $create_table_sql = "SHOW CREATE TABLE {$table};";
            $this->db1->query($create_table_sql);
            $this->db1->next_record();
            $real_create_table .= "DROP TABLE IF EXISTS `{$table}`;\n\r";
            $real_create_table .= $this->db1->row_data['Create Table'] . ";\n\r";
        }

        $replace = array();
        #$replace['ENGINE=MyISAM DEFAULT CHARSET=latin1']="";
        $replace['ENGINE=MyISAM'] = "";
        $replace['DEFAULT CHARSET=latin1'] = "";
        $replace['DEFAULT CHARSET=utf8'] = "";
        $replace[' varchar('] = ' VARCHAR(';
        $replace[' int('] = ' INT(';
        $replace[' int '] = ' INT ';
        $replace[' date'] = ' DATE ';
        $replace[' auto_increment'] = ' AUTO_INCREMENT';
        $replace[' zerofill'] = ' ZEROFILL';
        $replace[' text'] = ' TEXT';
        $replace[' tinytext'] = ' TINYTEXT';
        $replace[' on'] = ' ON';
        $replace[' update'] = ' UPDATE';
        $replace[' default'] = ' DEFAULT';
        $replace[' timestamp'] = ' TIMESTAMP';
        $replace[' smallint'] = ' SMALLINT';

        foreach ($replace as $k => $v)
            $real_create_table = str_replace($k, $v, $real_create_table);

        return $real_create_table;
    }

    /**
     * Build INSERT statements
     *
     * @param     $table_name
     * @param int $from_index
     * @param int $to_offset
     *
     * @return string
     */

    function insert_statement($table_name, $from_index = 0, $to_offset = 0)
    {
        $limit_sql = "";
        if ($to_offset > 0) {
            $limit_sql = " LIMIT {$from_index}, {$to_offset}";
        }

        $insert_sql = "";
        $insert_taker = "SELECT * FROM {$table_name} {$limit_sql};";
        $this->db1->query($insert_taker);
        while ($this->db1->next_record()) {
            $this->db1->row_data = $this->fix_quotation($this->db1->row_data);

            # do not modify below!
            $column_name_list = "";
            $column_value_list = "";
            $c = 0;
            foreach ($this->db1->row_data AS $k => $v) {
                $comma = "";
                if ($c > 0) {
                    $comma = ",";
                }
                if (mysql_field_type($this->db1->RESULTSET, $c) != "int") {
                    $quot = "\"";
                } else {
                    $quot = "";
                    if ($v == "") {
                        $v = "NULL";
                    }
                }
                $column_name_list .= "{$comma} {$k}";
                $column_value_list .= "{$comma} {$quot}{$v}{$quot}";
                ++$c;
            }

            $insert_sql .= "
INSERT INTO {$table_name} ( {$column_name_list} ) VALUES ( {$column_value_list} );";
            # echo($insert_sql);
        } # while($db1)
        return $insert_sql;
    } # create_tables

    /**
     * @param $array
     *
     * @return mixed
     */

    function fix_quotation($array)
    {
        foreach ($array as $key => $value) {
            $value = str_replace('"', "\\\"", $value);
            $array[$key] = $value;
        }

        return $array;
    } # insert_statement()

    /**
     * Short insert statements
     *
     * @param     $table_name
     * @param int $from_index
     * @param int $to_offset
     *
     * @return string
     */
    function insert_statement_improved($table_name, $from_index = 0, $to_offset = 0)
    {
        $limit_sql = "";
        if ($to_offset > 0) {
            $limit_sql = " LIMIT {$from_index}, {$to_offset}";
        }

        $d = 0;
        $insert_sql = "INSERT INTO {$table_name} VALUES ";
        $insert_taker = "SELECT * FROM {$table_name} {$limit_sql};";
        $this->db1->query($insert_taker);
        while ($this->db1->next_record()) {
            $this->db1->row_data = $this->fix_quotation($this->db1->row_data);

            # do not modify below!
            $column_value_list = "";
            $c = 0;
            foreach ($this->db1->row_data AS $k => $v) {
                $comma = "";
                if ($c > 0) {
                    $comma = ",";
                }
                if (mysql_field_type($this->db1->RESULTSET, $c) != "int") {
                    $quot = "\"";
                } else {
                    $quot = "";
                    if ($v == "") {
                        $v = "NULL";
                    }
                }
                $column_value_list .= "{$comma} {$quot}{$v}{$quot}";
                ++$c;
            }

            if (++$d > 1) {
                $insert_sql .= ", ";
            }
            $insert_sql .= "({$column_value_list})";
        } # while($db1)

        $insert_sql .= ";";

        return $insert_sql;
    } # insert_statement_improved()

    /**
     * Count total rows in a table
     *
     * @param string $table_name
     *
     * @return mixed
     */
    function count_data($table_name = "")
    {
        $sql = "SELECT COUNT(1) AS counter FROM {$table_name};";
        $this->db0->query($sql);
        $this->db0->next_record();

        return $this->db0->row_data['counter'];
    }
}
