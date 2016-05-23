<div class="form-wrap">
	<table>
		<tr>
			<td>
				<form autocomplete="off" name="contact-form" method="post" action="?attempt=send">
					<table class="data-editor">
						<tr class="{cycle values='A,B'}">
							<td class="attribute">Your Full Name: <span class="required">*</span></td>
							<td><input type="text" name="name" value="" class="input" placeholder="Full Name"/></td>
						</tr>
						<tr class="{cycle values='A,B'}">
							<td class="attribute">Email Address: <span class="required">*</span></td>
							<td><input type="text" name="email" value="" class="input" placeholder="email@domain.com"/>
							</td>
						</tr>
						<tr class="{cycle values='A,B'}">
							<td class="attribute">Subject: <span class="required">*</span></td>
							<td><input type="text" name="subject" value="" class="input" placeholder="Subject"/></td>
						</tr>
						<tr class="{cycle values='A,B'}">
							<td class="attribute">Message: <span class="required">*</span></td>
							<td><textarea rows="5" cols="75" name="message" class="textarea"
							              placeholder="Responsibly type your message here"></textarea></td>
						</tr>
						<tr class="{cycle values='A,B'}">
							<td class="attribute">&nbsp;</td>
							<td><input type="hidden" value="noemail" name="noemail"/>
								<input type="hidden" value="" name="nospam"/>
								<input type="submit" name="submit_button" value="Send" class="submit"/>
								<a href="./">Cancel</a></td>
						</tr>
					</table>
				</form>
			</td>
			<td>
				<iframe width="450" height="300" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/view?key={#GOOGLEMAPS_API_KEY#}&center={#GOOGLEMAPS_LATITUDE#},{#GOOGLEMAPS_LONGITUDE#}&zoom=18&maptype=satellite"></iframe>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
<script type="text/javascript" src="js/contact-us.js"></script>