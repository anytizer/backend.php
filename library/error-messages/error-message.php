<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Error Message</title>
    <link href="css/w3.css" rel="stylesheet" type="text/css"/>
    <link href="css/error-messages.css" rel="stylesheet" type="text/css"/>
</head>
<body class="w3-teal">
<div class="wrapper">
    <h1 class="w3-pale-red w3-padding">Ouch! Error...</h1>

    <div class="error-body"><?php
        if (is_object($message)) {
            print_r($message);
        } else {
            echo($message);
        } ?></div>

    <p class="administrator">- Administrator</p>

</div>
</body>
</html>
