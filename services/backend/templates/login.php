<!doctype html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8"/>
    <style type="text/css">
        * {
            padding: 0px;
            margin: 0px;
            border: none;
            outline: none;
        }

        body, td, th {
            color: #000066;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        body {
            background-color: #5da1c0;
            margin-left: 0px;
            margin-top: 150px;
            margin-right: 0px;
            margin-bottom: 150px;
        }

        h1 {
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            color: #333333;
            font-size: 18px;
            margin: 15px 0;
            /*background:url(images/login-key.png) no-repeat left top;*/
            background: url(data:image/png;base64,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) no-repeat left top;

            margin: 10px 0 7px -31px;
            padding: 13px 0 5px 45px;
            text-align: center;
            display: inline-block;
            _background: none;
        }

        a {
            color: #146ab2;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        td.field {
            text-align: right;
        }

        td.values {
            text-align: left;
        }

        table.data {
            margin-bottom: 20px;
            padding: 0;
        }

        td {
            padding: 4px;
        }

        input[type="text"], input[type="password"] {
            background-color: #FFFFFF;
            border: 1px solid #999999;
            width: 200px;
            height: 20px;
            padding: 2px;
        }

        input[type="text"]:hover, input[type="password"]:hover, input[type="text"]:focus, input[type="password"]:focus {
            background-color: #c3c5c5;
            color: #333333;
        }

        input.submit {
            /*background:#292929 url(images/login-background.png) repeat-x left top;*/
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAcCAIAAAAm1OLhAAAAB3RJTUUH2wIDCzUaj15u7wAAACVJREFUeJxjDAwMZEACLP///6cq/9+/fyTJU6qe1uZR2/0Uhi8A5JNR6UrrDXUAAAAASUVORK5CYII=) repeat-x left top;
            border: 1px solid #000000;
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            font-weight: bold;
            color: #ececec;
            text-align: center;
            height: 25px;
            padding: 2px 9px 5px 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #CC3300;
            color: #11b4e9;
        }

        /**
        * IE Patch
        */
        .input {
            background-color: #99CC99;
            border: 1px solid #0000FF;
            width: 200px;
            height: 20px;
            padding: 2px;
        }

        .input:hover, .input:focus {
            background-color: #CC6600;
            color: #FFFFFF;
        }

        .submit {
            background-color: #666666;
            border: 1px solid #0000FF;
            font-weight: bold;
            color: #FFFF00;
            text-align: center;
            height: 20px;
            padding: 2px;
        }

        .submit:hover {
            background-color: #CC3300;
            color: #FFFFFF;
        }

        .wrapper {
            width: 350px;
            margin: 0px auto 0px auto;
            background-color: #e9e9e9;
            border: 1px solid #666666;
            padding: 10px;
            border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
        }

        table.data tbody tr {
        }

        table.data tbody tr td {
            margin: 0px 0px 2px 0px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <form autocomplete="off" id="login-form" name="login-form" method="post" action="login.php">
        <div align="center">
            <h1>Login</h1>
            <table class="data" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="field">Usernane</td>
                    <td class="values"><input type="text" name="username" value="" class="input"/></td>
                </tr>
                <tr>
                    <td class="field">Password</td>
                    <td class="values"><input type="password" name="password" value="" class="input"/></td>
                </tr>
                <tr>
                    <td class="field">&nbsp;</td>
                    <td class="values"><input type="submit" name="login-action" value="Login" class="submit"/> or <a
                            href="./">Cancel</a></td>
                </tr>
            </table>
            <p>
                <a href="http://www.opera.com/browser/">Opera</a>, <a href="http://www.mozilla.com/firefox/">Firefox</a>,
                <a href="http://www.apple.com/safari/">Safari</a>, <a href="http://www.google.com/chrome/">Chrome</a> |
                <a href="{$smarty.const.__DEVELOPER_URL__}">{$smarty.const.__DEVELOPER_NAME__}</a></p>

            <p>&copy; 2011 - {'Y'|date}.</p>
        </div>
    </form>
</div>
<script type="text/javascript">
    document.forms['login-form'].elements['username'].focus();
</script>
</body>
</html>
