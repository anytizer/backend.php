<!doctype html>
<html>
<head>
    <!--
    Error message template: message.php
    Produced on: __TIMESTAMP__, __SUBDOMAIN_NAME__
    -->
    <title>__SUBDOMAIN_NAME__ - {$message.title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8"/>
    <link href="css/management.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper">
    <h1 class="content-title">{$message.title}</h1>

    <div class="contents">
        <div class="system-message">{$message.message}</div>
    </div>
    <div class="clear"></div>
    <div class="footer">
        <p>&copy; 2009 - {'Y'|date}, {$smarty.const.__DEVELOPER_NAME__}, <a
                href="http://__SUBDOMAIN_NAME__/">__SUBDOMAIN_NAME__</a>. All rights reserved.</p>
    </div>
</div>
</body>
</html>
