<!doctype html>
<html>
<head>
    <title>{$smarty.const.__FRAMEWORK_NAME__} - {$page.page_title|default:$smarty.const.__FRAMEWORK_NAME__}</title>
    <meta charset="utf-8"/>
    <meta name="keywords" content="{$page.meta_keywords|default:$smarty.const.__FRAMEWORK_META_KEYWORDS__}"/>
    <meta name="description" content="{$page.meta_description|default:$smarty.const.__FRAMEWORK_META_DESCRIPTION__}"/>
    <link href="css/framework.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper">
    <div class="menus">
        <ul class="links-collection">
            {menus context='company:top'}
        </ul>
    </div>
    <div class="main"> {if $smarty.session.user_id}
        <div align="right"><a
                href="pages-edit.php?pi={$page_details.page_id}"><strong>Admin</strong>: Modify this page's contents</a>
        </div>
        {/if}
        <div class="page-introduction">
            <!--{* short introduction *}-->
            <h1>{$page.content_title|default:'No title'}</h1>

            <div class="page-description">{$page.content_text|default:'No Contents'}</div>
        </div>
        <div class="page-contents">
            <!-- seeking template file: {$page.include_file} -->
            <!--{* custom programmed contents: a special template file to include. *}-->{if
            $page.include_file|valid_template}{include file=$page.include_file}{/if}<!-- end of {$page.include_file} -->
        </div>
    </div>
    <div class="footer">
        <div>
            <ul class="links-collection-footer">
                {menus context='framework:admin'}
            </ul>
            <ul class="links-collection-footer">
                {menus context='framework:footer'}
            </ul>
        </div>
        <div class="developer">
            <p><a href="https://goo.gl/WnpFxB">Backend Framework</a>, &copy; 2010 - {'Y'|date}</p>
            <p><a href="http://www.famfamfam.com/lab/icons/silk/">FAMFAMFAM Silk Icons used.</a></p>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/no-right-click.js"></script>
</body>
</html>
