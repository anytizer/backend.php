<?php
namespace common;

/**
 * Validates database structures
 */
class database_structure_validator extends \common\mysql
{
    # List of acceptable Data Types
    private $common_types = array(
        'string',
        'int',
        'real',
        'blob',
        'date',
        'enum', # Incomplete definition...

        # optional list
        'year',
    );

    # List of undesired Data Types - marks as error if found
    private $uncommon_types = array(
        'datetime',
        'timestamp',
        # 'year',
        # 'time',
    );

    # Avoid using these fields
    private $warnable_types = array(
        'binary',
        'bit',
        'bool',
        'char',
        'decimal',
        'double',
        'longblob',
        'longtext',
        'mediumblob',
        'mediumtext',
        'numeric',
        'real',
        'set',
        'timestamp',
        'tinyblob',
        'tinytext',
        'varbinary',

        #'[a-z]+[blob|text]',
    );

    # These fields are automatically zero-filled assumed.
    private $disregard_zerofills = array(
        'year',
    );

    # CSS Class Names (Selectors)
    private $error = 'error';
    private $warning = 'warning';
    private $blob = 'blob';
    private $good = "";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Compares if a name is in lowercase
     */
    public function lowercase($name = "")
    {
        return $name == strtolower($name);
    }

    /**
     * Specifies if a filed type is uncommon.
     */
    public function css_common_type($name = "")
    {
        if (in_array($name, $this->uncommon_types)) {
            echo $this->error;
        } else {
            echo in_array($name, $this->common_types) ? $this->good : $this->warning;
        }
    }


    # echo($meta->zerofill==1)?'error':"";
    public function css_zerofill($zerofill = false, $type = "")
    {
        echo (!in_array($type, $this->disregard_zerofills) && $zerofill) ? $this->warning : $this->good;
    }

    # If a filed value is empty, warn
    public function empty_field_warning($field_value = "")
    {
        echo $field_value ? $this->good : $this->warning;
    }

    # If a filed value is empty, error
    public function empty_field_error($field_value = "")
    {
        echo $field_value ? $this->good : $this->error;
    }

    # Check the standards of the table name
    public function css_table_name($table_name = "", $within_table = false)
    {
        $name = (!$within_table && (preg_match('/^[^a-z]/', $table_name) || strtolower($table_name) != $table_name)) ? $this->warning : $this->good;
        return $name;
    }

    # Check the standards of the field name
    function css_field_name($field_name = "")
    {
        # Begins with Non numeric, non underscore
        # Contains an underscore in between (prefix used)
        # Lowercase
        if (strtolower($field_name) != $field_name) {
            echo $this->error;
        } else {
            echo (preg_match('/^[^\d\_]/', $field_name) && preg_match('/\_/', $field_name)) ? $this->good : $this->warning;
        }
    }

    public function css_primary_key($is_primary_key = false, $is_multiple_key = false, $flags = "", $type)
    {
        if ($is_primary_key && $is_multiple_key) {
            # A combination only, possibly allowed.
            echo $this->warning;
        } else {
            # When a primary key, but not a multiple (unique)  key is not AUTO_INCREMENT
            #  && $type=='int'
            echo ($is_primary_key && !preg_match('/auto_increment/', $flags)) ? $this->error : $this->good;
        }
    }

    # Data Types validation
    public function css_datatype($datatype = "")
    {
        $css = $this->good;
        /*		foreach($this->common_types as $good_type)
                {
                    # Dont check for good types
                    if(preg_match("/^{$type}/", $datatype))
                        echo $css;
                        return; # Important here
                }*/

        #Avoid int(11) unsigned: force int(10) unsigned
        if (preg_match('/^int/', $datatype)) {
            if (!preg_match('/^int\(10\)/', $datatype)) {
                $css = $this->warning;
            }
        } else if (preg_match('/^float/', $datatype)) {
            # Marks : 5,2
            # Amount: 8,2
            if (!preg_match('/^float\([5|8]\,2\)/', $datatype)) {
                $css = $this->warning;
            }
        } #else if( preg_match('/^tinyint/', $datatype) || preg_match('/^smallint/', $datatype) )
        else if (preg_match('/^[a-z]+int/', $datatype)) {
            $css = $this->warning;
        } # STRING datatype matches - string, varchar, enum, ...
        else if (preg_match('/^varchar/', $datatype)) {
            # varchar(255)
            if (!preg_match('/^varchar\((50|100|255)\)/', $datatype)) {
                $css = $this->warning;
            }
        } else {
            foreach ($this->warnable_types as $type) {
                if (preg_match('/^' . $type . '/', $datatype)) {
                    $css = $this->error;
                    break;
                }
            }
        }

        echo $css;
    }

    public function css_max_length($length = 0)
    {
        $css = $this->good;
        if (!in_array($length, array(null, 1, 10, 255, 65535), false)) {
            $css = $this->warning;
        }

        echo $css;
    }

    /**
     * Force use of NOT NULL
     */
    public function css_not_null($not_null = false)
    {
        echo $not_null ? $this->good : $this->error;
    }

    /**
     * Check numeric fields against unsinged
     */
    public function css_numeric($is_numeric = false, $is_unsigned = false)
    {
        echo ($is_numeric && !$is_unsigned) ? $this->error : $this->good;
    }

    /**
     * BLOB marker
     */
    public function css_blob($is_blob = false)
    {
        echo $is_blob ? $this->blob : $this->good;
    }

    /**
     * Reads Engine/Comments combination of a table
     */
    function table_comments($table_name = "")
    {
        $show_create_table_sql = "SHOW CREATE TABLE `{$table_name}`;";

        /**
         * @todo Replace with MySQLi
         */
        $rs = mysqli_query($this->CONNECTION, $show_create_table_sql);
        #echo $rs;
        if (!mysqli_num_rows($rs)) {
            $table = array('Create Table' => "",);
        } else {
            $table = mysqli_fetch_assoc($rs);
        }
        #print_r($table);

        #die($table['Create Table']);

        # ) ENGINE=INNODB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='Fee items to charge'
        $data = array();
        #preg_match('#\) ENGINE=(.*?) .*? COMMENT=\'(.*?)\'#', $table['Create Table'], $data);
        #preg_match_all('#\) ENGINE=([a-z]+)#is', $table['Create Table'], $data); # Works for ENGINE
        #preg_match_all('#\).*?COMMENT=\'(.*?)\'#is', $table['Create Table'], $data); # Works for COMMENT

        # Works for comment and engine
        preg_match_all('#\) ENGINE=([a-z]+).*?COMMENT=\'(.*?)\'#is', $table['Create Table'], $data, PREG_SET_ORDER);

        #print_r($data);

        return isset($data[0][2]) ? $data[0][2] : "";
    }
}
