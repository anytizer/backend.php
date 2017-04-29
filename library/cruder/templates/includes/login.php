<form autocomplete="off" id="login-form" name="login-form" method="post" action="login.php" target="_top">
    <table class="data">
        <tr class="{cycle values='A,B'}">
            <td class="field" width="60">Username:</td>
            <td class="values"><input type="text" name="username" value="" class="input"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="field">Password:</td>
            <td class="values"><input type="password" name="password" value="" class="input"/></td>
        </tr>
        <!--{*
        <tr class="{cycle values='A,B'}">
            <td class="field">&nbsp;</td>
            <td class="values">
                <input type="checkbox" name="remember" value="remember" class="checkbox" id="remember"/>
                <label for="remember">Remember my login</label>
            </td>
        </tr>
        *}-->
        <tr class="{cycle values='A,B'}">
            <td class="field">&nbsp;</td>
            <td class="values"><img width="120" height="40" alt="Captcha Image" src="captcha.php?rand={random}"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="field">Type This:</td>
            <td class="values">&#x21b3;
                <input style="width:95px;" type="text" name="security_code" id="security_code" value=""/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="field">&nbsp;</td>
            <td class="values">
                <input type="submit" name="login-action" value="Login" class="submit"/> or <a href="./">Cancel</a>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
<script type="text/javascript">
    document.forms['login-form'].elements['username'].focus();
    var v = new Validator('login-form');
    v.addValidation('username', 'required', 'Please type your username');
    v.addValidation('password', 'required', 'Please type your password');
</script>