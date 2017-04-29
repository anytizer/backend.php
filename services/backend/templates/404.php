<!doctype html>
<html>
<head>
    <title>404 Error</title>
    <meta charset="utf-8"/>
    <link href="css/framework.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper" style="padding:20px;">
    <h1>404 Error - We did not find: {$page_name}</h1>

    <div
        style="padding:30px; border:1px solid #FF6600; background-color:#FFFF99; margin-bottom:10px;">{if
        $message}{$message}{else}Sorry, the page you are trying to view is not here.{/if}
    </div>
    <h2>Did you click a link from somewhere else in our site?</h2>

    <p>We might have missed the link. <a href="https://goo.gl/WnpFxB">Email us</a> to fix it.</p>

    <h2>Did you follow a link from another site?</h2>

    <p> Links from other sites can sometimes be outdated or misspelled. We'd like to fix that problem too, consider
        dropping us an
        <a href="https://goo.gl/WnpFxB">email us</a> so we can try to contact the other site and fix the problem.
    </p>

    <h2>Did you type the URL?</h2>

    <p> You may have typed the address (URL) incorrectly. Check to make sure you've got the exact right spelling,
        capitalization, etc.</p>

    <p>Meanwhile, maybe you'd like to go back to our <a href="./">Home Page</a>?</p>
</div>
<script type="text/javascript" src="js/no-right-click.js"></script>
</body>
</html>
