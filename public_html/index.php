<?php
header("HTTP/1.0 404 Not Found");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>index.php - Unused</title>
    <link href="css/protection.css" type="text/css" rel="stylesheet" />
</head>
<body>
<h2>.htacces/web.config - rewrite error</h2>

<p>There is <em class="error">no use</em> of <strong>index.php</strong>. Rather use one of:</p>
<ul>
    <li><strong class="database">mysql-version.php</strong></li>
    <li><strong class="database">mssql-version.php</strong> (support removed)</li>
    <li><strong class="database">pgsql-version.php</strong> (support removed)</li>
</ul>
<p>When fixed, <a href="./">reload the home page</a>.</p>
</body>
</html>
