<?php
#namespace plugins;

/**
 * This is a worthless expression control to make an HTML block null.
 * Helpful for the visual page designers only, eg. Macromedia Dreamweaver
 */
function smarty_block_html_comment($params, $content, &$smarty, &$repeat)
{
	# {comment type='html' status='on'}
	# {comment type='html' status='off'}
	# return "<!-- {$content} -->";
	# {comment}...{/comment}

	return null;
}
