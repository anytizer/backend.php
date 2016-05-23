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
<form autocomplete="off" id="domains-add-form" name="domains-add-form" method="post" action="domains-add.php">
	<table class="data">
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
		<tr class="{cycle values='A,B'}">
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
				                                                                 class="vanish"/>
				<!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
				<input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
				                                                                                name="add-action"
				                                                                                value="Add Domains"/>
				<input type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
					href="{\common\url::last_page('domains-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<!-- Add validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/domains/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of domains Add -->