<!--{*
Created on: 2011-03-29 23:48:23 316
*}-->
<div class="information">
	<ul class="links">
		<li><a href="permissions-list.php"><img src="{'table'|icon}" title="List Entity Permissions"
		                                        alt="List Entity Permissions"/> List Entity Permissions</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form id="permissions-add-form" name="permissions-add-form" method="post" action="permissions-add.php">
	<table class="data">
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Full Name:</td>
			<td><input type="text" name="permissions[full_name]" value="{$permissions.full_name|htmlentities}"
			           class="input" id="permissions-full_name"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Crud Name:</td>
			<td><input type="text" name="permissions[crud_name]" value="{$permissions.crud_name|htmlentities}"
			           class="input" id="permissions-crud_name"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Table Name:</td>
			<td><input type="text" name="permissions[table_name]" value="{$permissions.table_name|htmlentities}"
			           class="input" id="permissions-table_name"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Pk Name:</td>
			<td><input type="text" name="permissions[pk_name]" value="{$permissions.pk_name|htmlentities}" class="input"
			           id="permissions-pk_name"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Written To:</td>
			<td><input type="text" name="permissions[written_to]" value="{$permissions.written_to|htmlentities}"
			           class="input" id="permissions-written_to"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
				                                                                 class="vanish"/>
				<!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
				<input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
				                                                                                name="add-action"
				                                                                                value="Add Entity Permissions"/>
				<input type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
					href="{\common\url::last_page('permissions-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<!-- Add validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/permissions/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of permissions Add -->