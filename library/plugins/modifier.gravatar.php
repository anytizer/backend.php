<?php
#namespace plugins;

# http://www.marvinmarcelo.com/smarty-gravatar-plugin/
/**
 * Gravatar
 *
 * @link http://www.marvinmarcelo.com
 *
 * @param string $email
 * @param bool $link_only
 * @return string
 */
function smarty_modifier_gravatar($email = "", $link_only = true)
{
	/**
	 * constant $gravatar_host
	 */
	$gravatar_host = "http://www.gravatar.com/avatar/";

	/**
	 * @link http://en.gravatar.com/site/implement/url
	 */
	$hash = strtolower(md5(trim($email)));
	# $src = $gravatar_host . $hash . ".jpg?";

	#$size = 60;
	#$src .= "s={$size}";

	#$default = "wavatar"; # identicon | wavatar
	#$src .= "d={$default}";

	#$rating = "G";
	#$src .= "r={$rating}";

	# http://www.gravatar.com/avatar/84479461bcb0bc84ef0afb92f82e2bab?rating=PG&size=60&default=wavatar
	$src = "http://www.gravatar.com/avatar/{$hash}?rating=PG&size=30&default=wavatar";

	$extras = "";

	if($link_only === true)
	{
		return $src;
	}
	else
	{
		return "<img alt=\"\" class=\"author-icon\" src=\"$src\" />";
	}
}
