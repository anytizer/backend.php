<!-- Created on: 2010-11-15 13:36:42 243 -->
<div class="information">
	<ul class="links">
		<li><a href="cdn-list.php"><img src="{'table'|icon}" title="List cdn" alt="List cdn"/> List CDN </a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form autocomplete="off" id="cdn-add-form" name="cdn-add-form" method="post" action="cdn-add.php">
	<table class="data">
		<!--{*
			"Auto Generated" list of columns. Please adjust according to your needs.
			Remove [ cdn_id ] in the list.
		*}-->
		<tr>
			<td class="attribute">Name:</td>
			<td><input type="text" class="input" name="cdn[cdn_name]" value="{$cdn.cdn_name|htmlentities}"/></td>
		</tr>
		<tr>
			<td class="attribute">MIME:</td>
			<td><input type="text" class="input" name="cdn[cdn_mime]" value="{$cdn.cdn_mime|htmlentities}"/></td>
		</tr>
		<tr>
			<td class="attribute">Local Link:</td>
			<td><input type="text" class="input" name="cdn[cdn_local_link]" value="{$cdn.cdn_local_link|htmlentities}"/>
			</td>
		</tr>
		<tr>
			<td class="attribute">Remote Link:</td>
			<td><input type="text" class="input" name="cdn[cdn_remote_link]"
			           value="{$cdn.cdn_remote_link|htmlentities}"/></td>
		</tr>
		<tr>
			<td class="attribute">Comments:</td>
			<td><input type="text" class="input" name="cdn[cdn_comments]" value="{$cdn.cdn_comments|htmlentities}"/>
			</td>
		</tr>
		<tr>
			<td class="attribute">Version:</td>
			<td><input type="text" class="input" name="cdn[cdn_version]" value="{$cdn.cdn_version|htmlentities}"/></td>
		</tr>
		<tr>
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="text" name="is_spam" value="" style="display:none; visibility:hidden;"/>
				<!--{* only spammers fill this, Leave blank. *}-->
				<input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
				                                                                                name="add-action"
				                                                                                value="Add cdn"/> <input
					type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
					href="{\common\url::last_page('cdn-list.php')}">Cancel</a></td>
		</tr>
	</table>
</form>
{* Add validation *}
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/cdn/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of cdn Add -->