<?php
namespace common;
use \common\mysql;

/**
 * MySQL extension to build CSV output from the tables.
 *
 * @package Databases
 */
class csv
    extends mysql
{
    /**
     * Make an CSV output
     *
     * @param string $table Name of the database table, or the SQL string
     * @param boolean $is_sql Is the given string an SQL instead of a table name?
     *
     * @return string CSV text
     */
    public function to_csv($table = "", $is_sql = false)
    {
        $sql = "SELECT * FROM {$table};"; #  LIMIT 20;
        if ($is_sql === true) {
            $sql = $table;
        }

        $string = "";
        $this->query($sql);
        while ($this->next_record()) {
            $words = array();
            for ($i = 0; $i < $this->FIELDS_COUNTER; ++$i) {
                $field = $this->FIELDS[$i];
                #$word = ($this->row_data[$field]!="")?$this->row_data[$field]:"NULL";
                #if($this->META_DATA[$field]->type!="int")
                {
                    $word = '"' . $this->__unformat_text($this->row_data[$field]) . '"';
                }
                $words[] = $word;
            }
            $string .= implode(',', $words) . ";\n";
        }

        return $string;
    } # to_csv()

    /**
     * Properly enquote the texts with slashes and quotes.
     * <br>De-forms the text than the original.
     *
     * @param string $text
     *
     * @return string Enquoted text
     */
    public function __unformat_text($text = "")
    {
        #return $text; # as it is...
        $t = addslashes($text);

        #$t = htmlspecialchars_decode($t, ENT_NOQUOTES);
        return $t;
    } # enquote()

    /**
     * Properly enquote the texts with slashes and quotes.
     * <br>Purpose: Make mysql queries safer to work with INSERT, ...
     *
     * @param string $text
     *
     * @return mixed Enquoted text
     */
    public function enquote($text = "")
    {
        $enquoted_text = stripcslashes($text);

        $enquoted_text = str_replace("\\", "\\\\", $text);
        $enquoted_text = str_replace("\"", "\\\"", $text);
        $enquoted_text = str_replace("'", "\\\'", $text);

        return $enquoted_text;
    } # __format_text()

    /**
     * Properly de-quote the texts from slashes and quotes.
     * <br>Re-forms the original text once modified.
     *
     * @param $text
     *
     * @return string Originally enquoted text
     */
    public function __format_text($text)
    {
        #return $text; # as it is...
        $t = stripslashes($text);

        #$t = htmlspecialchars($t, ENT_QUOTES);
        return $t;
    } # __unformat_text()

    /**
     * Get the table names
     *
     * @return mixed
     */
    public function get_tables_list()
    {
        $sql = "SHOW TABLES;";
        $this->query($sql);
        global $dbinfo;
        $tables = $this->to_columnar_array('Tables_in_' . $dbinfo[$dbinfo['dbindex']]['database']);

        return $tables;
    } # get_tables_list()

    /**
     * Collect the table creating information
     *
     * @param string $table
     *
     * @return mixed
     */
    public function create_table_sql($table = "")
    {
        $sql = "SHOW CREATE TABLE `{$table}`;";
        $this->query($sql);
        $this->next_record();
        #\common\stopper::debug($this->row_data, false); \common\stopper::message();
        # $this->FIELDS[1]
        $table_sql = $this->row_data['Create Table'];

        return $table_sql;
    } # create_table_sql()
}
