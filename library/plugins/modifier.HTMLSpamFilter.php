<?php
#namespace plugins;

/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty HTMLSpamFilter modifier plugin
 * Type:     modifier<br>
 * Name:     HTMLSpamFilter<br>
 * Purpose:  Replace the sensitive HTML to bad/word.
 * @see |safe
 *
 * @link http://smarty.php.net/manual/en/language.modifier.HTMLSpamFilter.php
 *          HTMLSpamFilter (Smarty online manual)
 * @author   Bimal Poudel
 *
 * @param string Any text, NOT HTML, without the hyperlinks.
 *
 * @return string
 */
function smarty_modifier_HTMLSpamFilter($string = '', $trim_at = 3)
{
	$boring_comments_html = '';
	$return = '';
	for($i = 0; $i < strlen($string); $i++)
	{
		$return .= '&#x' . bin2hex(substr($string, $i, 1)) . ';';
		if($trim_at > 0 && $i % $trim_at == ($trim_at - 1))
		{
			$boring_comments_html = '<!--' . mt_rand(10, 99) . '-->';
			$return .= $boring_comments_html;
		}
	}

	return $return;
} # HTMLSpamFilter()

/*
Crawlers and spammers annoy by collecting the emails or other sensitve information on the website. Here is a modifer plugin to fix this case.

Remember, it is not able to fix the hyperlink-ed texts.

Protect your email display now, the much better way.

# Some value is assigned as:
$smarty->assign('email', 'author@book.com');

# Template usage examples and output

Template Usage:
{$email|HTMLSpamFilter:0}
{$email|HTMLSpamFilter:2}
{$email|HTMLSpamFilter:4}
{$email|HTMLSpamFilter:8}

Corresponding output:
&#x61;&#x75;&#x74;&#x68;&#x6f;&#x72;&#x40;&#x62;&#x6f;&#x6f;&#x6b;&#x2e;&#x63;&#x6f;&#x6d;
&#x61;&#x75;<!--52-->&#x74;&#x68;<!--92-->&#x6f;&#x72;<!--39-->&#x40;&#x62;<!--47-->&#x6f;&#x6f;<!--97-->&#x6b;&#x2e;<!--45-->&#x63;&#x6f;<!--46-->&#x6d;
&#x61;&#x75;&#x74;&#x68;<!--74-->&#x6f;&#x72;&#x40;&#x62;<!--61-->&#x6f;&#x6f;&#x6b;&#x2e;<!--88-->&#x63;&#x6f;&#x6d;
&#x61;&#x75;&#x74;&#x68;&#x6f;&#x72;&#x40;&#x62;<!--22-->&#x6f;&#x6f;&#x6b;&#x2e;&#x63;&#x6f;&#x6d;

Notes: Use the $trim_at postion correctly. 3 can be suitable for most applications.

# Direct access example:
# echo(smarty_modifier_HTMLSpamFilter('author@book.com', 3));

*/
