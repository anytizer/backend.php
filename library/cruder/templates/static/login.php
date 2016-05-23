<form autocomplete="off" id="login-form" name="login-form" method="post" action="login.php">
	<table class="data">
		<tr>
			<td class="field" width="60">Usernane:</td>
			<td class="values"><input type="text" name="username" value="" class="input" placeholder="username"/></td>
		</tr>
		<tr>
			<td class="field">Password:</td>
			<td class="values"><input type="password" name="password" value="" class="input" placeholder="password"/>
			</td>
		</tr>
		<tr>
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
