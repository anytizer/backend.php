<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="keywords" content="Backend Framework, Company Name"/>
	<meta name="description" content="We did not hold the page you requested for."/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>404 Error</title>
	<link href="css/404.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper">
	<h1>Page NOT Found!</h1>

	<p>Your requested page is <strong>not available</strong> at the moment.</p>

	<p>May be you typed a wrong page name, or we have not yet used this name.</p>

	<p>Possible solution: <strong>Register</strong> this page first.</p>
	<!--{* if cms was installed amd admin has logged in, give a direct link to add a page *}-->    {if isset($smarty.session.user_id) && $smarty.session.user_id}
	<p class="error-name">Add: <a href="cms-add.php?name={$page_name}">{$page_name|truncate:50}</a></p>
	{else}
	<p class="error-name"><a href="{$smarty.const.__DEVELOPER_URL__}">{$page_name|truncate:50}</a></p>
	{/if}
	<p class="admin"> - Administrator<br/> Server Time: {'Y-m-d H:i:s'|date}<br/> IP Address:
		<strong>{$smarty.server.REMOTE_ADDR}</strong>
	</p>
</div>
</body>
</html>
