<!doctype html>
<html>
<head>
    <!--
    Parent Template File (Admin Purpose)
    Produced on: __TIMESTAMP__, __SUBDOMAIN_NAME__
    Mobile Version
    -->
    <title>Admin - __SUBDOMAIN_NAME__ - {$page.page_title|default:$smarty.const.__FRAMEWORK_NAME__}</title>
    <meta charset="utf-8"/>
    <meta name="keywords" content="{$page.meta_keywords|default:$smarty.const.__FRAMEWORK_META_KEYWORDS__}"/>
    <meta name="description" content="{$page.meta_description|default:$smarty.const.__FRAMEWORK_META_DESCRIPTION__}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="css/mobile.css" rel="stylesheet" type="text/css"/>
</head>
<body id="body-admin">
<div class="wrapper">
    <div class="nav-container">
        <!-- main navigator starts -->
        <div class="navigator-main">
            <ul class="menu nav">
                <li class="current"><a href="dashboard.php">Dashboard</a>
                    <ul>
                        <li><a href="dashboard.php">Home</a></li>
                        <li><a href="./" target="website">Website</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Contents</a>
                    <ul>
                        <li><a href="cms-list.php">CMS</a></li>
                        <li><a href="emails-list.php">Email Templates</a></li>
                    </ul>
                </li>
                <li><a href="members-list.php">Members</a></li>
                <li><a href="logout.php">Logout</a></li>
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
</div>
</body>
</html>
