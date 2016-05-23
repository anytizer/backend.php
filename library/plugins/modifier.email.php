<?php
#namespace plugins;

/**
 * Encrypts an email for showing up in the HTML.
 * It does not have any security.
 */
function smarty_modifier_email($email = '')
{
	$search = array(
		'-',
		'_',
		'@',
		'.',
	);

	$replace = array(
		'<!-- - -->(hyphen)<!-- - -->',
		'<!--_-->(underscore)<!--_-->',
		'<!--at-->(at)<!--at-->',
		'<!--dot-->(dot)<!--dot-->',
	);
	$email = str_replace($search, $replace, $email);

	return $email;
} # email()
