<?php
#namespace plugins;

/**
 * Primary key into column value
 */
function smarty_modifier_table($pk_id = 0, $table = '', $column_name = '', $primary_key = '', $is_unsafe = true)
{
	# Save time/resources in case zero or empty values arrived.
	if(!$pk_id)
	{
		return '';
	}

	# Usage examples:
	# {$user.emp_state|table:'country_states':'state_name':'state_code':false}
	# {$state_id|table:'country_states':'state_name':'state_id'}
	$db = new \common\mysql();

	return $db->get_table_value($table, $column_name, $primary_key, $pk_id, $is_unsafe);
}
