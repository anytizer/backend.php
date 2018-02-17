<?php
namespace abstracts;
use \common\mysql;
use \others\condition;

/**
 * Database Entity for total CURD functions.
 *
 * Class entity
 * @package abstracts
 */
abstract class entity
    extends mysql
{
    /**
     * Change these values to affect globally.
     * These keys are used to generate protection codes while editing/listing the records.
     */
    protected $code_prefix = '@COMPANY@';
    protected $code_suffix = '%NAME%';

    /**
     * Set Private, Protected or Public Members
     */
    protected $protection_code = ""; # Some random text, valid for the entire life
    protected $table_name = ""; # Name of this table/entity name
    protected $pk_column = ""; # Primary Key's Column Name

    /**
     * Pagination helper
     *
     * @todo See if it should be public member
     */
    protected $total_entries_for_pagination = 0; # Number of entries: list_entries()

    # Validator fields for various CRUD actions
    # Enlist columns and their default values in associative arrays.
    protected $fields = array(
        'add' => array(),
        'edit' => array(),
    );

    /**
     * Quickly establish the connection to the database
     */
    public function __construct()
    {
        # Begin connection to the database, immediately.
        parent::__construct();
    }

    abstract public function list_entries(condition $condition, $from_index = 0, $per_page = 50);

    abstract public function details($__PK_NAME__ = 0);

    abstract public function get_details($__PK__NAME__ = 0, $protection_code = "");

    # Backward compatibility: Old CRUDed files might not have these methods.
    # abstract public function welcome_first($__PK_NAME__=0);

    /**
     * Add a new entry into [ __ENTITY__ ]
     *
     * @param $data array Associative array of columns in [ __ENTITY__ ]
     * @param $skip_protection_code boolean Whether to check protection code. Custom coded ADD scripts avoid this.
     *
     * @return Integer (__ENTITY__ ID) as entered into the database.
     */
    public function add($data = array(), $skip_protection_code = false)
    {
        $variable = new \common\variable();
        $protection_code = $variable->post('protection_code', 'string', "");

        if ($skip_protection_code !== true) {
            if (!$this->is_valid_code($protection_code)) {
                # Invalid code submitted to add a record
                return false;
            }
        } else {
            # Most likely the user came here from intended admin area or custom coded scripts.
        }

        $crud = new \backend\crud();
        $__PK_NAME__ = $crud->add(
            $this->table_name,
            $data,
            array(),
            false,
            false
        );

        return $__PK_NAME__;
    }

    /**
     * Matches the user-returned protection code with its valid one
     * @return boolean Code valid status
     */
    protected function is_valid_code($protection_code = "")
    {
        $real_code = $this->code();
        $is_valid = (($real_code == $protection_code) && ($protection_code != ""));

        return $is_valid;
    }

    /**
     * Returns the encrypted protection code in a dynamic manner
     * Advanced use: Use this method to write a self hack for management purpose.
     * Example: $_POST[""] =
     *
     * @return string Protection code
     */
    public function code($pk_id = 0)
    {
        $pk_id = (int)$pk_id;
        $protection_code = "";
        if (!$pk_id) {
            # User is requesting a code of the entire entity
            $protection_code = md5("{$this->code_prefix}{$this->table_name}{$this->protection_code}{$this->pk_column}{$this->code_suffix}");
        } else {
            # User is requesting a code of a particular record
            $protection_code_sql = "SELECT MD5(CONCAT(`{$this->pk_column}`, '{$this->protection_code}')) protection_code FROM `{$this->table_name}` WHERE `{$this->pk_column}`={$pk_id};";
            $record = $this->row($protection_code_sql);
            if (isset($record['protection_code'])) {
                $protection_code = $record['protection_code'];
            }
        }

        return $protection_code;
    }

    /**
     * Quickly add a records: data should come form a trusted source only
     * It does not take care of data safety
     * Hence use it for admin purpose, performing known tasks
     *
     * @param array $array Associative array of the data
     *
     * @return integer Last Insert ID
     */
    public function add_quick($array = array())
    {
        $ao = new array_operation();

        $keys = array_keys($array);
        $keys = implode(', ', $ao->operate('wrap_ticks', $keys));

        $values = array_values($array);
        $values = implode(', ', $ao->operate('quote', $values));

        $insert_id = 0;
        $add_quick_sql = "INSERT INTO `{$this->table_name}` ({$keys}) VALUES ($values);";
        if ($this->query($add_quick_sql)) {
            $insert_id = $this->insert_id();
        }

        return $insert_id;
    }

    /**
     * Edit/Modify/Update an entry in [ __ENTITY__ ]
     * Post Controller Method Only!
     *
     * @param array $data Associative array to modify
     * @param array $pk Associative array of primary keys and values
     * @param string $protection_code Secret Hash Key
     *
     * @return Boolean Success or Failure to edit a record
     */
    public function edit($data = array(), $pk = array(), $protection_code = "", $__PK_NAME__ = 0)
    {
        # Use $protection_code ... to test the integrity of the posted items.
        # First, Verifies if the user can edit the entry with the supplied protection code.
        $protection_code = $this->sanitize($protection_code);
        $__PK_NAME__ = (int)$__PK_NAME__;

        $edit_success = false;
        if ($this->allow_protected_action($__PK_NAME__, $protection_code)) {
            $crud = new \backend\crud();
            $edit_success = $crud->update(
                $this->table_name,
                $data,
                $pk
            );
        } else {
            \common\stopper::message('Invalid protection code used to modify a record.');
        }

        return $edit_success;
    }

    /**
     * Sanitize code against hacks
     * @return string Sanitized conent safe for using in SQLs
     */
    protected function sanitize($string = "")
    {
        return \common\tools::sanitize_name($string);
    }

    /**
     * Allow to operate on a particular record, with its protection code
     */
    protected function allow_protected_action($pk_column_id = 0, $protection_code = "")
    {
        # Action is: edit:update / delete:inactivate
        $pk_column_id = (int)$pk_column_id;
        $protection_code = $this->sanitize($protection_code);
        $test_allow_action_sql = "
SELECT
	(COUNT(`{$this->pk_column}`) = 1) `allow`
FROM `{$this->table_name}` `e`
WHERE
	`{$this->pk_column}` = {$pk_column_id}

	# This is NOT optional: Must Pass
	AND MD5(CONCAT(`{$this->pk_column}`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $permission = $this->row($test_allow_action_sql);
        $allow_protected_action = (isset($permission['allow']) && $permission['allow'] == 1);

        return $allow_protected_action;
    }

    /**
     * Delete a record from [ __ENTITY__ ]
     *
     * @param string $mode
     * @param int $__PK_NAME__
     * @param string $protection_code
     * @return bool
     */
    public function delete($mode = 'inactivate', $__PK_NAME__ = 0, $protection_code = "")
    {
        $__PK_NAME__ = (int)$__PK_NAME__;
        $protection_code = $this->sanitize($protection_code);
        #\common\stopper::message("Deleting: {$__PK_NAME__} - {$protection_code}");

        $delete_success = false;
        if ($this->allow_protected_action($__PK_NAME__, $protection_code)) {
            $crud = new \backend\crud();
            $delete_success = $crud->delete(
                $mode,
                $table_name = $this->table_name,
                $pk_column = $this->pk_column,
                $pk_value = $__PK_NAME__
            );
        }

        return $delete_success;
    }

    /**
     * Reads out the total number of entries
     * Pagination helper
     *
     * @return integer Total number of entries for pagination
     */
    public function total_entries()
    {
        return $this->total_entries_for_pagination;
    }

    /**
     * Validates data required for an action.
     * This helps to build missing indices.
     */
    public function validate($action = 'delete', &$variable_associative)
    {
        $variable = new \common\variable();
        $variable_associative = $variable->validate_variable($variable_associative, $this->fields[$action]);

        return $variable_associative;
    }

    /**
     * Block actions: delete, disable, enable, prune, nothing
     * Perform a certain action in a group of IDs. Extend only if you need them
     * The switch/case here is to save total number of registered pages by reusing the URL pattern.
     *
     * @return integer Total number of records that were probably affected.
     */
    public function blockaction($action = 'nothing', $ids = array())
    {
        # Filter that each IDs are numeric only
        $ids = array_filter($ids, array(new \common\tools(), 'numeric_only'));
        if (!$ids) {
            return false;
        }

        switch ($action) {
            case 'delete':
                $this->blockaction_delete($ids);
                break;
            case 'disable':
                $this->blockaction_disable($ids);
                break;
            case 'enable':
                $this->blockaction_enable($ids);
                break;
            case 'prune':
                #$this->blockaction_prune($ids);
                break;
            case 'nothing':
            default:
                # Do nothing
                break;
        }

        return count($ids);
    }

    /**
     * Delete a list of IDs. Extend this function, if required.
     * @return integer Rows deleted
     */
    protected function blockaction_delete($ids = array())
    {
        $ids_csv = implode(', ', $ids);
        $disable_sql = "UPDATE `{$this->table_name}` SET is_active='N' WHERE `{$this->pk_column}` IN($ids_csv);";
        $this->query($disable_sql);

        return $this->affected_rows();
    }

    /**
     * Disable a list of IDs. Extend this function, if required.
     * @return boolean Query Status
     */
    protected function blockaction_disable($ids = array())
    {
        $ids_csv = implode(', ', $ids);
        $disable_sql = "UPDATE `{$this->table_name}` SET is_approved='N' WHERE `{$this->pk_column}` IN($ids_csv);";

        return $this->query($disable_sql);
    }

    /**
     * Regularly clean of the system databases (on demand only)
     * It is a destructive process - to physically remove the records.
     */
    #abstract public function blockaction_prune($ids=array());

    /**
     * Enable a list of IDs. Extend this function, if required.
     * @return boolean Query Status
     */
    protected function blockaction_enable($ids = array())
    {
        $ids_csv = implode(', ', $ids);
        $disable_sql = "UPDATE `{$this->table_name}` SET is_approved='Y' WHERE `{$this->pk_column}` IN($ids_csv);";

        return $this->query($disable_sql);
    }
}
