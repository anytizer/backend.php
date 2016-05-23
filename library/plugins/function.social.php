<?php
#namespace plugins;

/**
 * Social links sharing
 */
function smarty_function_social($params = array(), &$smarty)
{
	$social_html = '';

	$params['title'] = isset($params['title']) ? urlencode($params['title']) : 'Social linking';
	$url = urlencode("{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}{$_SERVER['REQUEST_URI']}");

	/* @group Social */
	/**
	 * <style type='text/css' media='screen'>
	 * #social { position: fixed; left: 0; top: 40px; z-index: 10000; }
	 * #social img { padding-bottom: 0.5em; }
	 * </style>
	 */
	/* @end */
	$social_html = "
<div id='social'>
	<div id='facebook'>
		<a class='facebook' href='http://www.facebook.com/sharer.php?u={$url}&amp;t={$params['title']}%3F%20(%20{$url}%20)' target='_blank'>
			<img src='images/social/facebook.png' alt='Facebook' />
		</a>
	</div>
	<div id='twitter'>
		<a class='twitter' href='http://twitter.com/home?status={$params['title']}%3F%20(%20{$url}%20)' target='_blank'>
			<img src='images/social/twitter.png' alt='Twitter' />
		</a>
	</div>
	<div id='digg'>
		<a class='digg' href='http://digg.com/submit?phase=2&amp;title={$params['title']}%253F&amp;url={$url}' target='_blank'>
			<img src='images/social/digg.png' alt='Digg' />
		</a>
	</div>
	<div id='reddit'>
	<a class='reddit' href='http://reddit.com/submit?title={$params['title']}%253F&amp;url={$url}' target='_blank'>
		<img src='images/social/reddit.png' alt='Reddit' />
	</a>
	</div>
</div>
";

	return $social_html;
}
