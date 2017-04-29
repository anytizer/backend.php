<?php
namespace \subdomain;

#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * `__ENTITY__` Class
 */
class __ENTITY__
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
        $this->protection_code = '__PROTECTION_CODE__'; # Some random text, valid for the entire life
        $this->table_name = '__TABLE__'; # Name of this table/entity name
        $this->pk_column = '__PK_NAME__'; # Primary Key's Column Name

        /**
         * Minimum validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                __FIELDS_ADD__
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                __FIELDS_EDIT__
            ),
        );
    }

    /**
     * List entries from [ `__ENTITY__` ]
     * Column `code` signifies a protection code while deleting/editing a record
     *
     * @param condition $condition SQL Conditions
     * @param int $from_index
     * @param int $per_page
     *
     * @return array Multi-Dimensional array of entries in the list
     */
    public function list_entries(\others\condition $condition, $from_index = 0, $per_page = 50)
    {
        $crud = new \backend\crud();

        /**
         * Conditions are Compiled here so that we can manupulate them individually.
         * And make them fit for [ __ENTITY__ ] only.
         */
        $conditions_compiled_AND = $crud->compile_conditions(
            $condition->get_condition('AND'),
            false, 'AND', 2
        );
        $conditions_compiled_OR = $crud->compile_conditions(
            $condition->get_condition('OR'),
            false, 'OR', 2
        );

        $from_index = (int)$from_index;
        $per_page = (int)$per_page;

        $listing_sql = "
SELECT SQL_CALC_FOUND_ROWS
	e.`{$this->pk_column}`, -- Do not remove this

	-- Modify these columns to your own required list (e.*)
	__FIELDS_LIST__,

	-- Flags, load them as per your need
	e.`is_approved`,

	MD5(CONCAT(e.`{$this->pk_column}`, '{$this->protection_code}')) `code` -- Protection Code
FROM `{$this->table_name}` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	-- We assume that the sorting fields are available
	e.`sink_weight` ASC,
	e.`{$this->pk_column}` DESC
LIMIT {$from_index}, {$per_page}
;";
        $entries = $this->arrays($listing_sql);

        # Pagination helper: Set the number of entries
        $counter_sql = "SELECT FOUND_ROWS() total;"; # Uses SQL_CALC_FOUND_ROWS from above query. So, run it immediately.
        $totals = $this->row($counter_sql);
        $this->total_entries_for_pagination = isset($totals['total']) ? $totals['total'] : 0;

        return $entries;
    }

    /**
     * Details of an entity in [ __ENTITY__ ] for management activities only.
     *
     * @param int $__PK_NAME__ integer Primary Key's value of an entity
     *
     * @return array $details Associative Array of Detailed records of an entity
     */
    public function details($__PK_NAME__ = 0, $protection_code = "")
    {
        global $subdomain_id;
        $protection_code = $this->sanitize($protection_code);

        $__PK_NAME__ = (int)$__PK_NAME__;
        $details_sql = "
SELECT
	e.`{$this->pk_column}`, # Do not remove this

	e.*, # Modify these columns,

	# Admin must have it to EDIT the records
	MD5(CONCAT(e.`{$this->pk_column}`, '{$this->protection_code}')) `code` # Protection Code
FROM `{$this->table_name}` `e`
WHERE
	e.`{$this->pk_column}` = {$__PK_NAME__}
	AND e.is_active='Y'
	
	AND e.subdomain_id={$subdomain_id}
	AND MD5(CONCAT(`{$this->pk_column}`, '{$this->protection_code}')) = '{$protection_code}'
;";

        return $this->row($details_sql);
    }

    /**
     * Details of an entity in [ `__ENTITY__` ] for public display.
     *
     * @param int $__PK_NAME__ Primary Key's value of an entity
     * @param string $protection_code
     *
     * @return array Associative Array of Detailed records of an entity
     */
    public function get_details($__PK_NAME__ = 0, $protection_code = "")
    {
        $__PK_NAME__ = (int)$__PK_NAME__;
        $protection_code = $this->sanitize($protection_code);
        $details_sql = "
SELECT
	e.`{$this->pk_column}`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(e.`{$this->pk_column}`, '{$this->protection_code}')) `code` # Protection Code
FROM `{$this->table_name}` `e`
WHERE
	e.`{$this->pk_column}` = {$__PK_NAME__}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(e.`{$this->pk_column}`, '{$this->protection_code}')) = '{$protection_code}'
;";

        return $this->row($details_sql);
    }

    /**
     * Flag a particular field; dummy use; unless you use it.
     * Every method should sanitize the user input.
     * It will co-exist with the live features.
     *
     * @param int $__PK_NAME__
     * @param string $protection_code
     * @param string $field_name
     *
     * @return bool
     */
    public function flag_field($__PK_NAME__ = 0, $protection_code = "", $field_name = "")
    {
        # Allow only selected fields to be flagged Y/N
        if (!in_array($field_name, array('is_approved', 'is_featured', 'is_reported', 'is_private'))) {
            # Such flag does not exist.
            return false;
        }

        $__PK_NAME__ = (int)$__PK_NAME__;
        $protection_code = $this->sanitize($protection_code);
        global $subdomain_id;

        $flag_sql = "
UPDATE `{$this->table_name}` SET
	# Set your flag name here
	`{$field_name}`=IF(`{$field_name}`='Y', 'N', 'Y'),
	modified_on=CURRENT_TIMESTAMP()
WHERE
	`{$this->pk_column}` = {$__PK_NAME__}
	AND subdomain_id={$subdomain_id}

	# Optionally, do not touch the deleted flags
	AND is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`{$this->pk_column}`, '{$this->protection_code}')) = '{$protection_code}'
;";

        return $this->query($flag_sql);
    }

    /**
     * Welcome and ask for authentication?
     * Please extend this method according to your business logic.
     * eg. Send email to the first signed up member, trigger something else when a data is added.
     * Called right after a new [ `__ENTITY__` ] is added: insert-hook.
     *
     * @param int $__PK_NAME__
     *
     * @return bool
     */
    public function welcome_first($__PK_NAME__ = 0)
    {
        $__PK_NAME__ = (int)$__PK_NAME__;

        return true;
    }
}
