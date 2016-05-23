<div class="form-wrap">
	<form autocomplete="off" id="password-change-form" name="password-change-form" method="post" action="password-change.php">
		<table class="data-editor">
			<tr style="background-color:#FFFF99;">
				<td class="attribute">Old Password:</td>
				<td class="value"><input type="password" name="password[old]" value="" class="input"
				                         placeholder="old-password"/></td>
			</tr>
			<tr style="background-color:#99FF99;">
				<td class="attribute">New Password:</td>
				<td class="value"><input type="password" name="password[new]" value="" class="input"
				                         placeholder="new-password"/></td>
			</tr>
			<tr style="background-color:#99FF99;">
				<td class="attribute">Confirm Password:</td>
				<td class="value"><input type="password" name="password[confirm]" value="" class="input"
				                         placeholder="new-password-again"/></td>
			</tr>
			<tr>
				<td class="attribute">&nbsp;</td>
				<td class="value">
					<input type="hidden" name="change-password" value="Change Password"/> <input type="submit"
					                                                                             name="password-change-action"
					                                                                             value="Change Password"
					                                                                             class="submit"/> or <a
						href="./">Cancel</a>
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="js/validator/gen_validatorv4.js"></script>
<script type="text/javascript">
	var v = new Validator('password-change-form');
	v.EnableMsgsTogether();

	v.addValidation('password[old]', 'required', 'Please type your old password.');
	v.addValidation('password[new]', 'required', 'Please type your new password.');
	v.addValidation('password[confirm]', 'required', 'Please type your confirmation password.');

	/**
	 * Password confirmation
	 * Disallows to re-use the old password.
	 * Empty values are checked by the validtor itself
	 */
	function type_same_passwords()
	{
		var pcf = document.forms['password-change-form'];
		if(pcf.elements['password[new]'].value == pcf.elements['password[old]'].value && pcf.elements['password[new]'].value)
		{
			window.alert('We do not accept same old password again.');
			return false;
		}

		if(pcf.elements['password[new]'].value != pcf.elements['password[confirm]'].value)
		{
			window.alert('Your new password and confirmation password mismatched.');
			return false;
		}

		return true;
	}
	v.setAddnlValidationFunction(type_same_passwords);
</script>