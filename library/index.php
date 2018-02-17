<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Templates safety!</title>
    <style type="text/css">
        <?php readfile("public_html/css/errors.css"); ?>
    </style>
</head>
<body>
<h1>Sorry, but these files are protected!</h1>

<p>You cannot browse into this section directly, due to security issues.</p>
<p>We have informed our staffs about your visit.</p>

<p><em>Administrator</em> @ <?php echo $_SERVER['SERVER_NAME']; ?></p>
</body>
</html>
