<?php
#namespace plugins;

/**
 * Allows to input date in user defined format
 * @todo Replace with JQuery UI Tools
 *
 * @param array $params
 * @param $smarty
 *
 * @return string
 *
 * @example Index ID: Comma Separated list of HTML Element IDs where we have to attach the date picker
 * @example {datepicker id='date1,date2'}
 * @example {datepicker id='date1,date2' live=true}
 */
function smarty_function_datepicker($params = array(), &$smarty)
{
	$params['id'] = !empty($params['id']) ? $params['id'] : "";
	if(!$params['id'])
	{
		return "";
	}

	$params['live'] = !empty($params['live']) ? (boolean)$params['live'] : "";

	$params['id'] = str_replace('#', "", $params['id']);
	$ids = explode(',', $params['id']);
	foreach($ids as $i => $id)
	{
		$ids[$i] = '#' . $id;
	}
	$ids_list = implode(',', $ids);

	$html = "";

	/**
	 * @todo Use live resource: Upgrade to latest release and test
	 */
	if($params['live'])
	{
		$html = "
<!-- added: 20120830, http://jqueryui.com/demos/datepicker/ -->
<link rel='stylesheet' href='http://code.jquery.com/ui/1.8.23/themes/base/jquery-ui.css' type='text/css' media='all' />
<link rel='stylesheet' href='http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css' type='text/css' media='all' />
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js' type='text/javascript'></script>
<script src='http://code.jquery.com/ui/1.8.23/jquery-ui.min.js' type='text/javascript'></script>
";
	}
	else
		# Use local resource
	{
		$html = "
<link rel='stylesheet' href='js/ui/css/smoothness/jquery-ui-1.8.22.custom.css' type='text/css' />
<script type='text/javascript' src='js/ui/js/jquery-ui-1.8.22.custom.min.js'></script>
";
	}

	# Main date picker
	$html .= "
<script type='text/javascript'>
	$('{$ids_list}').datepicker({ dateFormat: 'yy-mm-dd' });
</script>
";

	return $html;
}
