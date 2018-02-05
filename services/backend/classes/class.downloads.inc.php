<?php
namespace subdomain;

# Created on: 2010-12-14 00:48:38 194

/**
 * downloads Class
 */

/**
 * Operations:
 *    $downloads->add()
 *        Adds a new record in downloads
 *    $downloads->edit()
 *        Modified a record in downloads
 *    $downloads->delete()
 *        Removes one of downloads record
 *    $downloads->list_entries()
 *        Fetches a list of downloads records
 *    $downloads->details()
 *        Fetches the details of downloads
 */
class downloads
    extends abstracts\entity
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
        $this->protection_code = '29e82713e41e98e175228565718b2a31'; # Some random text, valid for the entire life
        $this->table_name = 'query_distributions'; # Name of this table/entity name
        $this->pk_column = 'distribution_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                'file_size' => null,
                'stats_comments' => null,
                'stats_html' => null,
                'stats_php' => null,
                'stats_js' => null,
                'stats_css' => null,
                'stats_images' => null,
                'stats_text' => null,
                'stats_templates' => null,
                'stats_scripts' => null,
                'show_links' => null,
                'show_samples' => null,
                'distribution_link' => null,
                'distribution_title' => null,
                'distribution_text' => null,
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                'file_size' => null,
                'stats_comments' => null,
                'stats_html' => null,
                'stats_php' => null,
                'stats_js' => null,
                'stats_css' => null,
                'stats_images' => null,
                'stats_text' => null,
                'stats_templates' => null,
                'stats_scripts' => null,
                'show_links' => null,
                'show_samples' => null,
                'distribution_link' => null,
                'distribution_title' => null,
                'distribution_text' => null,
            ),
        );
    }

    /**
     * List entries from [ downloads ]
     * Column `code` signifies a protection code while deleting/editing a record
     *
     * @param $conditions SQL Conditions
     *
     * @return Multi-Dimensional array of entries in the list
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
	e.`distribution_id`, # Do not remove this
	
	# Modify these columns to your own list(e.*)
	e.`file_size`,
	e.`stats_comments`,
	e.`stats_php`,
	e.`stats_js`,
	e.`stats_css`,
	e.`stats_images`,
	e.`stats_templates`,
	e.`stats_scripts`,
	e.`show_links`,
	e.`show_samples`,
	e.`distribution_link`,
	e.`distribution_title`,
	e.`distribution_text`,
	
	MD5(CONCAT(`distribution_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_distributions` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	# We assume that the sorting fields are available
	`sink_weight` ASC,
	`distribution_id` DESC
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
     * Details of an entity in [ downloads ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($distribution_id = 0)
    {
        $distribution_id = (int)$distribution_id;
        $details_sql = "
SELECT
	e.`distribution_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`distribution_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_distributions` `e`
WHERE
	`distribution_id` = {$distribution_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ downloads ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($distribution_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $distribution_id = (int)$distribution_id;
        $details_sql = "
SELECT
	`distribution_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`distribution_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_distributions` `e`
WHERE
	`distribution_id` = {$distribution_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`distribution_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }
}