<?php
#namespace plugins;

/**
 * For various drop downs
 * @url http://www.smarty.net/forums/viewtopic.php?t=14990
 *
 * @example <select name="country" id="country">{html_options options='countries'|dropdown selected=''}</select>
 */

function smarty_modifier_dropdown($identifier = '', $replaces_kv = array())
{
	# Used to pull the Body SQL and real data SQL
	$db = new \common\mysql();

	# Each block MUST return k / v (key/value) columns only.
	$identifier_sql = '';
	$identifier = strtolower(preg_replace('/[^a-z0-9\_\-\:\.]/is', '', $identifier));
	switch($identifier)
	{
		# For a rapid development, put your SQLs here.
		# Later, when they mature, move to the database.
		default:
			# Searches for the SQLs if available in the database table: query_identifiers
			$identifier_body_sql = "SELECT identifier_sql `kv` FROM query_identifiers WHERE identifier_code='{$identifier}';";
			$body = $db->row($identifier_body_sql);
			$identifier_sql = isset($body['kv']) ? $body['kv'] : '';
	}

	# Try to replace the dynamic parts within the variables
	$db->query($identifier_sql);

	# Every output must have K/V association only
	$data = $db->to_association('k', 'v');

	return $data;
}
