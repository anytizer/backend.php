<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Error Message</title>
    <link href="css/error-messages.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper">
    <h1>Ouch! Error...</h1>

    <div class="error-body"><?php
        if (is_object($message)) {
            print_r($message);
        } else {
            echo($message);
        } ?></div>
    <p class="administrator">- Administrator</p>

    <div class="footer">
        <p>Domain: <a href="#"><?php echo $_SERVER['SERVER_NAME']; ?></p>
    </div>
</div>
<!--
<?php print_r($_SERVER); ?>
-->
</body>
</html>
