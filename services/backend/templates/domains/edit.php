<!--{*
Created on: 2011-02-14 12:48:48 850
*}-->
<div class="information">
	<ul class="links">
		<li><a href="domains-list.php"><img src="{'table'|icon}" title="List Domains" alt="List Domains"/> List Domains</a>
		</li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form autocomplete="off" id="domains-edit-form" name="domains-edit-form" method="post" action="domains-edit.php">
	<table class="data edit">
		<!-- file or image upload script/patch --><!--{*
	<tr class="{cycle values='A,B'} waring-overwrite">
		<td class="attribute">domains File/Picture:</td>
		<td>
			<input type="file" name="domainsfile" id="domainsfile" value="" />
			<a href="{$domains.domainsfile}" target="preview">View current</a>
		</td>
	</tr>
*}-->
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Check After:</td>
			<td><input type="text" name="domains[check_after]" value="{$domains.check_after|htmlentities}" class="input"
			           id="domains-check_after"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Response Code:</td>
			<td><input type="text" name="domains[response_code]" value="{$domains.response_code|htmlentities}"
			           class="input" id="domains-response_code"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Domain Name:</td>
			<td><input type="text" name="domains[domain_name]" value="{$domains.domain_name|htmlentities}" class="input"
			           id="domains-domain_name"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">URL Local:</td>
			<td><input type="text" name="domains[url_local]" value="{$domains.url_local|htmlentities}" class="input"
			           id="domains-url_local"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">URL Live:</td>
			<td><input type="text" name="domains[url_live]" value="{$domains.url_live|htmlentities}" class="input"
			           id="domains-url_live"/></td>
		</tr>
		<tr>
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
				                                                                 class="vanish"/>
				<!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
				<input type="hidden" name="domain_id" value="{$domains.domain_id}"/>
				<!-- This is different than system's protection code. This is related to particular ID. -->
				<input type="hidden" name="protection_code" value="{$domains.code}"/> <input type="hidden"
				                                                                             name="edit-action"
				                                                                             value="Edit Domains"/>
				<input type="submit" name="submit-button" class="submit" value="Save Changes"/> Or, <a
					href="{\common\url::last_page('domains-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<!-- Validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/domains/edit.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of domains Edit -->