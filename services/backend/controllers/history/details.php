<?php


# Created on: 2010-12-27 11:38:12 391

/**
 * Details of an entry in [ history ]
 */

$history_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ''); # Protection Code

if(!$history_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('history-direct-access-error.php?context=identity');
}
else
{
	$history = new \subdomain\history();

	# Try to load the details
	if($history_details = $history->details($history_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('history', $history_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('history-direct-access-error.php?context=data');
	}
}
