<?php
namespace backend;
use \common\mysql;

/**
 * Sorts the table entries with their sink_weight values, under some conditions.
 *
 * @example `$sorter = new \backend\sorter("AND `is_active`='Y'");`
 * @example `$sorter->sort_table('table_name', 'primary_key', $primary_key, $direction, 'sink_weight');`
 *
 * @todo Check if MySQLi conversion was good and works ok
 */
class sorter extends mysql
{
    private $context_sql;

    public function __construct($context_sql = "")
    {
        /**
         * Context SQL should be used to choose list of entries broadly.
         * Primary Keys should not be used here.
         */
        $this->context_sql = $context_sql;

        parent::__construct();
    }


    /**
     * Ups or Downs a row in the sorted list.
     * Warning: Order is maintained by {$sink_name} column only
     *
     * @param string $table_name Table name to sort
     * @param string $pk_name Name of primary key in this table
     * @param int $pk_id Value of current primary key to send upwards or downwards
     * @param string $direction Can always be one of: up/down
     * @param string $sink_name Name of column that holds the weights of entries to sort
     */
    public function sort_table($table_name = "", $pk_name = "", $pk_id = 0, $direction = 'up', $sink_name = 'sink_weight')
    {
        $direction = (in_array(strtolower($direction), array('up', 'upward', 'up', 'u'))) ? 'up' : 'down';

        # Validate PK ID.
        $pk_id = (int)$pk_id;

        # Sorting Direction
        $sort_amount = ($direction == 'up') ? '- 15' : '+ 15'; # Portion of SQL String

        $reset_current_sink_weight_sql = "
UPDATE `{$table_name}` SET
	`{$sink_name}` = (`{$sink_name}` {$sort_amount} )
WHERE
	`{$pk_name}` = {$pk_id}
;";
        $this->query($reset_current_sink_weight_sql);

        # Begin sorting by this number
        # Our system cannot hold negative and zero values.
        $sink_weight = 20;

        $choose_sorted_ids_sql = "
SELECT
	`{$pk_name}` id
FROM `{$table_name}`
WHERE
	TRUE
	{$this->context_sql}
ORDER BY
	`{$sink_name}` ASC
;";
        $rs = mysqli_query($this->CONNECTION, $choose_sorted_ids_sql);
        while ($list = mysqli_fetch_assoc($rs)) {
            $sink_weight += 10;

            # Increase the sort number by 15, of a pkid.
            $adjust_single_row_sql = "
UPDATE `{$table_name}` SET
	`{$sink_name}` = {$sink_weight}
WHERE
	`{$pk_name}` = {$list['id']}
;";
            $this->query($adjust_single_row_sql);

            # Select: pk_id, sink weight list in ascending order
            # Loop through each entries.
            # Add sorting each of the list.
        }
    }
}
