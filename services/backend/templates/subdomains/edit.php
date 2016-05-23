<!--{*
Created on: 2011-02-10 00:27:11 536
*}-->
<div class="information">
	<ul>
		<li><a href="subdomains-list.php"><img src="{'table'|icon}"/> List subdomains</a></li>
		<li><a href="subdomains-alias.php?id={$smarty.get.id}&amp;code={$smarty.get.code}"><img
					src="{'add'|icon}"/> Alias it others</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form autocomplete="off" id="subdomains-edit-form" name="subdomains-edit-form" method="post" action="subdomains-edit.php">
	<table class="data edit">
		<!-- file or image upload script/patch --><!--{*
	<tr class="{cycle values='A,B'} waring-overwrite">
		<td class="attribute">subdomains File/Picture:</td>
		<td>
			<input type="file" name="subdomainsfile" id="subdomainsfile" value="" />
			<a href="{$subdomains.subdomainsfile}" target="preview">View current</a>
		</td>
	</tr>
*}-->
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain Port:</td>
			<td><input type="text" name="subdomains[subdomain_port]" value="{$subdomains.subdomain_port|htmlentities}"
			           class="input" id="subdomains-subdomain_port"/> <a
					href="subdomains-install.php?id={$subdomains.subdomain_id}">Install Again</a>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain Name:</td>
			<td><input type="text" name="subdomains[subdomain_name]" value="{$subdomains.subdomain_name|htmlentities}"
			           class="input" id="subdomains-subdomain_name" style="background-color:#FF99CC;"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Comments:</td>
			<td><input type="text" name="subdomains[subdomain_comments]"
			           value="{$subdomains.subdomain_comments|htmlentities}" class="input"
			           id="subdomains-subdomain_comments"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain URL:</td>
			<td><input type="text" name="subdomains[subdomain_url]" value="{$subdomains.subdomain_url|htmlentities}"
			           class="input" id="subdomains-subdomain_url"/></td>
		</tr>
		<tr>
			<td class="attribute">Subdomain IP:</td>
			<td><input type="text" name="subdomains[subdomain_ip]"
			           value="{$subdomains.subdomain_ip|default:$subdomains.subdomain_name|gethostbyname|default:'0.0.0.0'}"
			           class="input" id="subdomains-subdomain_ip"/> Leave blank to auto find
			</td>
		</tr>
		<tr>
		<tr class="{cycle values='A,B'}" style="background-color:#006600; color:#FFFFFF;">
			<td class="attribute">Pointed To:</td>
			<td>
				<input type="text" name="subdomains[pointed_to]" value="{$subdomains.pointed_to|htmlentities}"
				       class="input" id="subdomains-pointed_to"/> Pipe ( | ) separate multiple locations if required.
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">FTP/FTPs Host:</td>
			<td><input type="text" name="subdomains[ftp_host]" value="{$subdomains.ftp_host|htmlentities}" class="input"
			           id="subdomains-ftp_host"/> Secured FTPs? Be careful!
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">FTP/FTPs Username:</td>
			<td><input type="text" name="subdomains[ftp_username]" value="{$subdomains.ftp_username|htmlentities}"
			           class="input" id="subdomains-ftp_username"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">FTP/FTPs Password:</td>
			<td><input type="password" name="subdomains[ftp_password]" value="{$subdomains.ftp_password|htmlentities}"
			           class="input" id="subdomains-ftp_password"/></td>
		</tr>
		<tr class="{cycle values='A,B'}" style="background-color:#006600; color:#FFFFFF;">
			<td class="attribute">FTP/FTPs Path:</td>
			<td><input type="text" name="subdomains[ftp_path]" value="{$subdomains.ftp_path|htmlentities}" class="input"
			           id="subdomains-ftp_path"/> WWW location?
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Prefix:</td>
			<td><input type="text" name="subdomains[subdomain_prefix]"
			           value="{$subdomains.subdomain_prefix|htmlentities}" class="input"
			           id="subdomains-subdomain_prefix"/> Database and other Prefix Value
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Description:</td>
			<td class="value"><textarea rows="5" cols="50" name="subdomains[subdomain_description]" class="editor"
			                            id="subdomains-subdomain_description">{$subdomains.subdomain_description|htmlentities}</textarea>
			</td>
		</tr>
		<tr>
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="email" value="" style="display:none; visibility:hidden;"/> <input type="text"
				                                                                                           name="is_spam"
				                                                                                           value=""
				                                                                                           style="display:none; visibility:hidden;"/>
				<!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
				<input type="hidden" name="subdomain_id" value="{$subdomains.subdomain_id}"/>
				<!-- This is different than system's protection code. This is related to particular ID. -->
				<input type="hidden" name="protection_code" value="{$subdomains.code}"/> <input type="hidden"
				                                                                                name="edit-action"
				                                                                                value="Edit Sub-Domains"/>
				<input type="submit" name="submit-button" class="submit" value="Save Changes"/> Or, <a
					href="{\common\url::last_page('subdomains-list.php')}">Cancel</a></td>
		</tr>
	</table>
</form>
<!-- Validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/subdomains/edit.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of subdomains Edit -->