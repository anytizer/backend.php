<!-- Created on: 2010-10-06 12:53:18 781 -->
<div class="information">
	<ul>
		<li><a href="smtp-list.php"><img src="{'table'|icon}"/> List SMTP</a></li>
	</ul>
</div>
<p>This is a very sensitive information. If there are conflicts, please modifiy the database manually.</p>
<form id="smtp-edit-form" name="smtp-edit-form" method="post" action="smtp-edit.php">
	<table class="data edit">
		<!--{*
			"Auto Generated" list of columns. Please adjust according to your needs.
			Remove [ smtp_id ] in the list.
		*}-->
		<tr>
			<td class="attribute">Subdomain ID:</td>
			<td>{$smtp.subdomain_id} - {$smtp.subdomain_id|table:'query_subdomains':'subdomain_name':'subdomain_id'}</td>
		</tr>
		<tr>
			<td class="attribute">SMTP Identifier:</td>
			<td>{$smtp.smtp_identifier}</td>
		</tr>
		<tr>
			<td class="attribute">Host:</td>
			<td><input type="text" class="input" name="smtp[smtp_host]" value="{$smtp.smtp_host|htmlentities}"/></td>
		</tr>
		<tr>
			<td class="attribute">Port:</td>
			<td><input type="text" class="input" name="smtp[smtp_port]" value="{$smtp.smtp_port|htmlentities}"/></td>
		</tr>
		<tr>
			<td class="attribute">Authenticate:</td>
			<td>
				<input type="text" class="input" id="smtp-do_authenticate" name="smtp[do_authenticate]"
				       value="{$smtp.do_authenticate|htmlentities}"/> Y/N only (<a href="#" id="put-Y">Yes</a> / <a
					href="#" id="put-N">No</a>)
			</td>
		</tr>
		<tr>
			<td class="attribute">Username:</td>
			<td><input type="text" class="input" name="smtp[smtp_username]" value="{$smtp.smtp_username|htmlentities}"/>
			</td>
		</tr>
		<tr>
			<td class="attribute">Password:</td>
			<td><input type="text" class="input" name="smtp[smtp_password]" value="{$smtp.smtp_password|htmlentities}"/>
			</td>
		</tr>
		<tr>
			<td class="attribute">From Name:</td>
			<td><input type="text" class="input" name="smtp[from_name]" value="{$smtp.from_name|htmlentities}"/></td>
		</tr>
		<tr>
			<td class="attribute">From Email:</td>
			<td><input type="text" class="input" name="smtp[from_email]" value="{$smtp.from_email|htmlentities}"/></td>
		</tr>
		<tr>
			<td class="attribute">Reply-To Name:</td>
			<td><input type="text" class="input" name="smtp[replyto_name]" value="{$smtp.replyto_name|htmlentities}"/>
			</td>
		</tr>
		<tr>
			<td class="attribute">Reply-To Email:</td>
			<td><input type="text" class="input" name="smtp[replyto_email]" value="{$smtp.replyto_email|htmlentities}"/>
			</td>
		</tr>
		<tr>
			<td class="attribute">Comments:</td>
			<td><input type="text" class="input" name="smtp[smtp_comments]" value="{$smtp.smtp_comments|htmlentities}"/>
			</td>
		</tr>
		<tr>
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="hidden" name="smtp_id" value="{$smtp.smtp_id}"/>
				<!-- This is different than system's protection code. This is related to particular ID. -->
				<input type="hidden" name="protection_code" value="{$smtp.code}"/> <input type="hidden"
				                                                                          name="edit-action"
				                                                                          value="Edit smtp"/> <input
					type="submit" name="submit-button" class="submit" value="Save Changes"/> Or, <a
					href="smtp-list.php">Cancel</a> | <a href="smtp-test.php?code={$smtp.smtp_identifier}">Test</a></td>
		</tr>
	</table>
</form>
{* Edit validation *}
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/smtp/edit.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of smtp Edit -->