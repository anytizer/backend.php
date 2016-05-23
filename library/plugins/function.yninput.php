<?php
#namespace plugins;

/**
 * Ask Yes/No Radio/Checkbox or Input.
 * Useful in editing flags.
 *
 * @example {yninput name='name[index]' value='Y'}
 * <div>{yninput name='name[yes]' value='Y'}</div>
 * <div>{yninput name='name[no]' value='N'}</div>
 */
function smarty_function_yninput($params = array(), &$smarty)
{
	$name = isset($params['name']) ? $params['name'] : '';
	$value = isset($params['value']) ? $params['value'] : '';

	$y_checked = ($value == 'Y') ? ' checked="checked"' : '';
	$n_checked = ($value == 'N') ? ' checked="checked"' : '';

	# Force to choose NO.
	if(!$y_checked && !$y_checked)
	{
		$n_checked = ' checked="checked"';
	}

	$input_html = '
<span class="radio"><input name="' . $name . '" type="radio" value="Y" ' . $y_checked . ' /> Yes</span>
<span class="radio"><input name="' . $name . '" type="radio" value="N" ' . $n_checked . ' /> No</span>
';

	return $input_html;
}
