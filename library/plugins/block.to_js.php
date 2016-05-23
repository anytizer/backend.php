<?php
#namespace plugins;

/**
 * Sends a javascript code into external temp file and reloads it.
 * @todo Check if useful
 */
function smarty_block_to_js($params = array(), $content = '', &$smarty, &$repeat)
{
	$external_js = '';

	$params['comments'] = isset($params['comments']) ? $params['comments'] : '';

	if(isset($content))
	{
		/**
		 * @todo Parameter less constructor
		 */
		$tj = new \backend\to_javascript(__TEMP_PATH__);
		//$js = $tj->write_external('//comments: '.$params['comments']);
		$js = $tj->write_external($content);

		$external_js = $tj->load_external('js/to_javascript.php?js=' . $js);
	}

	return $external_js;
}
