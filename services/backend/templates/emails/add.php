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
<form autocomplete="off" id="emails-add-form" name="emails-add-form" method="post" action="emails-add.php">
	<table class="data">
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain:</td>
			<td><select
					name="emails[subdomain_id]">{html_options options='system:subdomains_available'|dropdown selected=$emails.subdomain_id}</select>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Email Code:</td>
			<td><input type="text" name="emails[email_code]" value="{$emails.email_code|htmlentities}" class="input"
			           id="emails-email_code" readonly="readonly"/> Be careful here. Avoid duplications.
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Email Subject:</td>
			<td><input type="text" name="emails[email_subject]" value="{$emails.email_subject|htmlentities}"
			           class="input" id="emails-email_subject"/> Write subdomain prefix as well for easy reading
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">HTML Version:</td>
			<td class="value"><textarea rows="5" cols="50" name="emails[email_html]" class="editor"
			                            id="emails-email_html">{$emails.email_html|htmlentities}</textarea></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Plain Text Version:</td>
			<td class="value"><textarea rows="5" cols="50" name="emails[email_text]" class="text"
			                            id="emails-email_text">{$emails.email_text|htmlentities}</textarea></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
				                                                                 class="vanish"/>
				<!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
				<input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
				                                                                                name="add-action"
				                                                                                value="Add Emails"/>
				<input type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
					href="{\common\url::last_page('emails-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<!-- Add validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/emails/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of emails Add -->