<?php
#namespace plugins;

/**
 * Various ad-server and ad-killer
 * Shows real ads or replaces them with a readable information about the ad.
 *
 * @file function.advertise.php
 * Permissions granted to modify this page, but keep our ownership and copryrights message.
 * Donated to Smarty community.
 * For your usage, please replace the ad-codes with your own ads.
 * Examples:
 * {advertise type='infolinks'}
 * {advertise type='analytics'}
 *
 * @param array $params
 * @param $smarty
 * @return string
 */
function smarty_function_advertise($params = array(), &$smarty)
{
	$js = 'http://pagead2.googlesyndication.com/pagead/show_ads.js'; # When nothing matches

	$params['type'] = !empty($params['type']) ? $params['type'] : ""; # Show all the times? or filter in localhost?
	$params['force'] = !empty($params['force']) ? true : false;
	switch($params['type'])
	{
		case 'google-160-600': # Vertical ads
			$js = '
<!-- Ad Block -->
';
			break;
		case 'box':
			$js = '
<!-- Ad Block -->
';
			break;
		case 'link-unit':
			# Link Unit = 5 ads
			$js = '
<!-- Ad Block -->
';
			break;
		case 'google-url':
		case 'infolinks':
		default:
			$js = '
<!-- Ad Block -->
';
			break;
	}

	if($params['force'] === true)
	{
		# Forces an ad to display, all the times.
		return $js;
	}
	else
	{
		# Conditionally, shows an advertisement on live server.
		#$js .= ' <!-- printing ad: '.$params['type'].' --> '; # Print identity for debug message
		$advertise = ($_SERVER['SERVER_NAME'] != 'localhost') ? $js : "Ad contents: [{$params['type']}]";
		return $advertise;
	}
}
