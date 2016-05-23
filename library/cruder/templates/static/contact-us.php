<form autocomplete="off" name="contact-us-form" id="contact-us-form" method="post" action="contact-us.php">
	<table>
		<tr>
			<td>Your name:</td>
			<td><input type="text" name="contact[name]" value="" placeholder="Full Name"></td>
		</tr>
		<tr>
			<td>Your email:</td>
			<td><input type="email" name="contact[email]" value="" placeholder="email@domain.com"></td>
		</tr>
		<tr>
			<td>Subject:</td>
			<td><input type="text" name="contact[subject]" value="" placeholder="Subject"></td>
		</tr>
		<tr>
			<td>Message:</td>
			<td><textarea name="contact[message]" rows="5" cols="50" placeholder="Message"></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<!-- only spammers will fill this -->
				<input type="text" name="email" value="" style="visibility:hidden;"> <input type="submit"
				                                                                            name="contact-us"
				                                                                            value="Contact">
			</td>
		</tr>
	</table>
</form>
<h2>Alternative contacts</h2>
<p>Skype: | MSN: | Yahoo: | GMail:</p>
<p>Phone:</p>
