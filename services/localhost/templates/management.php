<!doctype html>
<html>
<head>
    <title>{$smarty.server.SERVER_NAME} - {$page.page_title|default:$smarty.const.__FRAMEWORK_NAME__}</title>
    <meta charset="utf-8"/>
    <meta name="keywords" content="{$page.meta_keywords|default:$smarty.const.__FRAMEWORK_META_KEYWORDS__}"/>
    <meta name="description" content="{$page.meta_description|default:$smarty.const.__FRAMEWORK_META_DESCRIPTION__}"/>
    <link href="css/localhost.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper">
    <div class="main">
        <div class="page-introduction">
            <!--{* short introduction *}-->
            <h1>{$page.content_title|default:'No title'}</h1>

            <div class="page-description">{$page.content_text|default:'No Contents'}</div>
        </div>
        <div class="page-contents">
            <!-- seeking template file: {$page.include_file} -->
            <!--{* custom programmed contents: a special template file to include. *}-->
            {if $page.include_file|valid_template}{include file=$page.include_file}{/if}
            <!-- end of {$page.include_file} -->
        </div>
    </div>
</div>
<script type="text/javascript" src="js/no-right-click.js"></script>
</body>
</html>
