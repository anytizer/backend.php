<?php
#namespace plugins;

/**
 * Prepends or removes the 'www.' in a domain name.
 * Helpful in shortening the name
 * @todo URL Parse
 *
 * @see |url, |www, |domain
 */
function smarty_modifier_www($domain_name = "", $prepend = true)
{
	if($prepend == false)
	{
		$domain_name = preg_replace('/^www\./is', "", $domain_name);
	}
	else
	{
		if(!preg_match('/^www\./is', $domain_name))
		{
			# Prepend www. if not available already
			$domain_name = 'www.' . $domain_name;
		}
	}

	return $domain_name;
}
