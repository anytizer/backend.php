<!--{*
Created on: 2011-02-02 00:36:55 983
*}-->
<div class="information">
	<ul class="links">
		<li><a href="superfish-list.php"><img src="{'table'|icon}" title="List Menus" alt="List Menus"/> List Menus</a>
		</li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form autocomplete="off" id="superfish-edit-form" name="superfish-edit-form" method="post" action="superfish-edit.php">
	<table class="data edit">
		<!-- file or image upload script/patch --><!--{*
	<tr class="{cycle values='A,B'} waring-overwrite">
		<td class="attribute">superfish File/Picture:</td>
		<td>
			<input type="file" name="superfishfile" id="superfishfile" value="" />
			<a href="{$superfish.superfishfile}" target="preview">View current</a>
		</td>
	</tr>
*}-->
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Parent ID:</td>
			<td><input name="superfish[parent_id]" type="text" class="input" id="superfish[parent_id]"
			           value="{$superfish.parent_id|htmlentities}"/> Be careful!
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Context:</td>
			<td>{$superfish.context}</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Menu Text:</td>
			<td class="value"><input name="superfish[menu_text]" type="text" class="input" id="superfish-menu_text"
			                         value="{$superfish.menu_text|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Menu Link:</td>
			<td><input type="text" name="superfish[menu_link]" value="{$superfish.menu_link|htmlentities}" class="input"
			           id="superfish-menu_link"/></td>
		</tr>
		<tr>
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="email" value="" style="display:none; visibility:hidden;"/> <input type="text"
				                                                                                           name="is_spam"
				                                                                                           value=""
				                                                                                           style="display:none; visibility:hidden;"/>
				<!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
				<input type="hidden" name="menu_id" value="{$superfish.menu_id}"/>
				<!-- This is different than system's protection code. This is related to particular ID. -->
				<input type="hidden" name="protection_code" value="{$superfish.code}"/> <input type="hidden"
				                                                                               name="edit-action"
				                                                                               value="Edit Menus"/>
				<input type="submit" name="submit-button" class="submit" value="Save Changes"/> Or, <a
					href="{\common\url::last_page('superfish-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<!-- Validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/superfish/edit.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of superfish Edit -->