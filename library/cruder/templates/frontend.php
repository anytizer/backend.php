<!doctype html>
<html>
<head>
    <!--
    Parent Template File (Admin Purpose)
    Produced on: __TIMESTAMP__, __SUBDOMAIN_NAME__
    -->
    <title>__SUBDOMAIN_NAME__ - {$page.page_title|default:$smarty.const.__FRAMEWORK_NAME__}</title>
    <meta charset="utf-8"/>
    <meta name="keywords" content="{$page.meta_keywords|default:$smarty.const.__FRAMEWORK_META_KEYWORDS__}"/>
    <meta name="description" content="{$page.meta_description|default:$smarty.const.__FRAMEWORK_META_DESCRIPTION__}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="css/management.css" rel="stylesheet" type="text/css"/>
    <script type='text/javascript' src='js/jquery-latest.js'></script>
</head>
<body id="body-frontend">
<div class="wrapper">
    <div class="header-wrapper">
        <div class="header">
            <h1 class="header-title"><a href="dashboard.php"><!--project-name--></a></h1>

            <div class="menus-top">
                <p>
                    <!-- rather use menu context plugin -->
                    {loginlink}
                </p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="nav-container">
        <!-- main navigator starts -->
        <div class="navigator-main">
            <ul class="menu nav">
                <li class="current"><a href="./">Home</a></li>
                <li><a class="item5" href="about-us.php">About Us</a></li>
                <li><a href="contact-us.php">Contact Us</a></li>
                <li><a href="reports.php">Reports</a></li>
                {cruded_menus}
            </ul>
            <div class="clear"></div>
        </div>
        <!-- main navigator ends -->
    </div>
    <div class="content-wrapper">
        <div class="content-panel">
            <div class="content-box">
                <div class="contents">
                    <h2 class="content-title">{$page.content_title}</h2>

                    <div class="system-message">
                        {$page.content_text}
                    </div>
                    <!-- if the messenger has something to relay -->
                    <div id="messenger-holder">{messenger}</div>
                    <div class="additional">
                        {if $page.include_file|valid_template} {include file=$page.include_file} {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="footer">
        <p class="copy-right">
            Copyright &copy; {#COPYRIGHT_SINCE#} - {'Y'|date}, <a
                href="http://__SUBDOMAIN_NAME__/">__SUBDOMAIN_NAME__</a>. All rights reserved.
            <!--
            Powered by <a
            href="{$smarty.const.__DEVELOPER_URL__}">{$smarty.const.__DEVELOPER_NAME__}</a>.
            -->
        </p>
        <!--
                <p class="copy-right" style="color:#FFFF00">
                    <strong>Warning</strong>:
                    The site is under extreme TESTING PHASE.
                    DO NOT WRITE ANY LIVE DATA.
                </p>
        -->
    </div>
</div>
<script type='text/javascript' src='js/theme02/menus-dropdown.js'></script>
{if is_live()}
<script type='text/javascript' src="js/google-analytics.js"></script>
{/if}
</body>
</html>
