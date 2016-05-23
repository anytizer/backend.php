<!doctype html>
<html>
<head>
	<title>{$smarty.const.__FRAMEWORK_NAME__} - {$page.page_title|default:$smarty.const.__FRAMEWORK_NAME__}</title>
	<meta charset="utf-8" />
	<meta name="keywords" content="{$page.meta_keywords|default:$smarty.const.__FRAMEWORK_META_KEYWORDS__}"/>
	<meta name="description" content="{$page.meta_description|default:$smarty.const.__FRAMEWORK_META_DESCRIPTION__}"/>
	<link href="css/framework.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<!--
{ascii_logo}
-->
<div class="wrapper">
	<div class="menus">
		<ul class="links-collection">
			{menus context='company:top'}
		</ul>
	</div>
	<div class="main">
		{if $smarty.session.user_id}
		<div align="right">
			<a href="pages-edit.php?pi={$page_details.page_id}"><strong>Admin</strong>: Modify this page's contents</a>
		</div>
		{/if}
		<div class="page-introduction">
			<!--{* short introduction *}-->
			<h1>{$page.content_title|default:'No title'}</h1>

			<div class="page-description">{$page.content_text|default:'No Contents'}</div>
		</div>
		<div class="page-contents">
			<!-- seeking template file: {$page.include_file} -->            <!--{* custom programmed contents: a special template file to include. *}-->            {if $page.include_file|valid_template}{include file=$page.include_file}{/if}            <!-- end of {$page.include_file} -->
		</div>
	</div>
	<div class="footer">
		<div>
			<ul class="links-collection-footer">{menus context='framework:admin'}</ul>
			<ul class="links-collection-footer">{menus context='framework:footer'}</ul>
		</div>
		<div class="developer">
			<p>&copy; 2009 - {'Y'|date}, <a
					href="{#COMPANY_URL#}">{#COMPANY_NAME#}</a>. All Rights Reserved. Managed from {#COMPANY_LOCATION#}.
			</p>

			<p>{#COMPANY_POSTBOX#} | Phone: {#COMPANY_PHONE#}</p>

			<p style="padding-top:20px;">{#COMPANY_MESSAGE#}</p>
		</div>
	</div>
</div>
<div class="w3-valid">
	<p>
		<!-- http://www.w3.org/Icons/valid-xhtml10-blue.png -->
		<a href="http://validator.w3.org/check?uri=referer"><img src="images/w3c/valid-xk.png"
		                                                         alt="Valid XHTML 1.0 Transitional" title=""/></a>
		<!-- http://jigsaw.w3.org/css-validator/images/vcss-blue -->
		<a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="images/w3c/valid-cx.png" alt="Valid CSS!"
		                                                                title=""/></a>
		<img src="images/w3c/valid-xs.png" alt="Valid CSS!" title=""/>
	</p>

	<p><a href="http://www.w3.org/QA/Tools/Icons">More QA Tools and Icons</a></p>
</div>
<script type="text/javascript" src="js/no-right-click.js"></script>
</body>
</html>
