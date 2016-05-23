<!--{*
Created on: 2011-02-10 00:27:11 536
*}-->
<div class="information">
	<ul class="links">
		<li><a href="subdomains-list.php"><img src="{'table'|icon}" title="List Sub-Domains"
		                                       alt="List Sub-Domains"/> List Sub-Domains</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form autocomplete="off" id="subdomains-add-form" name="subdomains-add-form" method="post" action="subdomains-add.php">
	<table class="data">
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain Name:</td>
			<td><input type="text" name="subdomains[subdomain_name]" value="{$subdomains.subdomain_name|htmlentities}"
			           class="input" id="subdomains-subdomain_name" style="background-color:#FF99CC;"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain Short:</td>
			<td><input type="text" name="subdomains[subdomain_short]" value="{$subdomains.subdomain_short|htmlentities}"
			           class="input" id="subdomains-subdomain_short"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain Comments:</td>
			<td><input type="text" name="subdomains[subdomain_comments]"
			           value="{$subdomains.subdomain_comments|htmlentities}" class="input"
			           id="subdomains-subdomain_comments"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Subdomain URL:</td>
			<td><input type="text" name="subdomains[subdomain_url]" value="{$subdomains.subdomain_url|htmlentities}"
			           class="input" id="subdomains-subdomain_url"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Pointed To:</td>
			<td><input type="text" name="subdomains[pointed_to]" value="{$subdomains.pointed_to|htmlentities}"
			           class="input" id="subdomains-pointed_to"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="email" value="" style="display:none; visibility:hidden;"/> <input type="text"
				                                                                                           name="is_spam"
				                                                                                           value=""
				                                                                                           style="display:none; visibility:hidden;"/>
				<!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
				<input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
				                                                                                name="add-action"
				                                                                                value="Add Sub-Domains"/>
				<input type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
					href="{\common\url::last_page('subdomains-list.php')}">Cancel</a></td>
		</tr>
	</table>
</form>
<!-- Add validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/subdomains/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of subdomains Add -->