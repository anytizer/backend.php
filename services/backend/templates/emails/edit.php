<!--{*
Created on: 2011-03-23 11:38:46 911
*}-->
<div class="information">
	<ul class="links">
		<li><a href="emails-list.php"><img src="{'table'|icon}" title="List Emails" alt="List Emails"/> List Emails</a>
		</li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form autocomplete="off" id="emails-edit-form" name="emails-edit-form" method="post" action="emails-edit.php">
	<table class="data edit">
		<!-- file or image upload script/patch --><!--{*
	<tr class="{cycle values='A,B'} waring-overwrite">
		<td class="attribute">emails File/Picture:</td>
		<td>
			<input type="file" name="emailsfile" id="emailsfile" value="" />
			<a href="{$emails.emailsfile}" target="preview">View current</a>
		</td>
	</tr>
*}-->
		<!--
			<tr class="{cycle values='A,B'}">
				<td class="attribute">Language:</td>
				<td>{$emails.language}{*<input type="text" name="emails[language]" value="{$emails.language|htmlentities}" class="input" id="emails-language" />*}</td>
			</tr>
		-->
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Email Code:</td>
			<td>{$emails.email_code} ({$emails.language}){*<input type="text" name="emails[email_code]"
			                                                      value="{$emails.email_code|htmlentities}"
			                                                      class="input" id="emails-email_code"/>*}
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain:</td>
			<td><select
					name="emails[subdomain_id]">{html_options options='system:subdomains_available'|dropdown selected=$emails.subdomain_id}</select>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Email Subject:</td>
			<td><input type="text" name="emails[email_subject]" value="{$emails.email_subject|htmlentities}"
			           class="input" id="emails-email_subject"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Email HTML:</td>
			<td class="value"><textarea rows="5" cols="50" name="emails[email_html]" class="editor"
			                            id="emails-email_html">{$emails.email_html|htmlentities}</textarea></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Email Text:</td>
			<td class="value"><textarea rows="5" cols="50" name="emails[email_text]" class="text"
			                            id="emails-email_text">{$emails.email_text|htmlentities}</textarea></td>
		</tr>
		<tr>
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
				                                                                 class="vanish"/>
				<!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
				<input type="hidden" name="email_id" value="{$emails.email_id}"/>
				<!-- This is different than system's protection code. This is related to particular ID. -->
				<input type="hidden" name="protection_code" value="{$emails.code}"/> <input type="hidden"
				                                                                            name="edit-action"
				                                                                            value="Edit Emails"/> <input
					type="submit" name="submit-button" class="submit" value="Save Changes"/> Or, <a
					href="{\common\url::last_page('emails-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<!-- Validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/emails/edit.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of emails Edit -->