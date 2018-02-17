<?php
namespace subdomain;

# Created on: 2010-11-15 13:36:42 243

/**
 * cdn Class
 */

/**
 * Operations:
 *    $cdn->add()
 *        Adds a new record in cdn
 *    $cdn->edit()
 *        Modified a record in cdn
 *    $cdn->delete()
 *        Removes one of cdn record
 *    $cdn->list_entries()
 *        Fetches a list of cdn records
 *    $cdn->details()
 *        Fetches the details of cdn
 */
class cdn
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
        $this->protection_code = 'e8f2a33c4801a73f295e6120e3ad36af'; # Some random text, valid for the entire life
        $this->table_name = 'query_cdn'; # Name of this table/entity name
        $this->pk_column = 'cdn_id'; # Primary Key's Column Name
    }

    /**
     * List entries from [ cdn ]
     * Column `code` signifies a protection code while deleting/editing a record
     *
     * @param \others\condition $condition SQL Conditions
     * @param int $from_index
     * @param int $per_page
     * @return array Multi-Dimensional array of entries in the list
     */
    public function list_entries(\others\condition $condition, $from_index = 0, $per_page = 50)
    {
        $crud = new \backend\crud();

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
	`cdn_id`, # Do not remove this
	
	# Modify these columns
	e.*,
	
	MD5(CONCAT(`cdn_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_cdn` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
LIMIT {$from_index}, {$per_page}
;";

# Extra
#	e.user_id = {$variable->session('user_id', 'integer', 0)}
#	AND e.is_active = 'Y'

        /*
                $listing_sql="
        SELECT SQL_CALC_FOUND_ROWS
            `cdn_id`, # Do not remove this

            # Modify these columns
            e.*,

            MD5(CONCAT(`cdn_id`, '{$this->protection_code}')) `code` # Protection Code
        FROM `query_cdn` `e`
        WHERE
            e.is_active='Y'
        LIMIT {$from_index}, {$per_page}
        ;";*/
        $this->query($listing_sql);
        $entries = $this->to_array();

        # Pagination helper: Set the number of entries
        $counter_sql = "SELECT FOUND_ROWS() total;"; # Uses SQL_CALC_FOUND_ROWS from above query. So, run it immediately.
        $totals = $this->row($counter_sql);
        $this->total_entries_for_pagination = $totals['total'];

        return $entries;
    }

    /**
     * Details of an entity in [ cdn ] for management activities
     *
     * @param int $cdn_id
     * @return array
     */
    public function details($cdn_id = 0)
    {
        $cdn_id = (int)$cdn_id;
        $details_sql = "
SELECT
	`cdn_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`cdn_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_cdn` `e`
WHERE
	`cdn_id` = {$cdn_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ cdn ] for public display.
     *
     * @param int $cdn_id
     * @param string $protection_code
     * @return array
     */
    public function get_details($cdn_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $cdn_id = (int)$cdn_id;
        $details_sql = "
SELECT
	`cdn_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`cdn_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_cdn` `e`
WHERE
	`cdn_id` = {$cdn_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`cdn_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }
}