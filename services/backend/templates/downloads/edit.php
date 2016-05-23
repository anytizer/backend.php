<!--{*
Created on: 2010-12-14 00:48:38 194
*}-->
<div class="information">
	<ul class="links">
		<li><a href="downloads-list.php"><img src="{'table'|icon}" title="List downloads"
		                                      alt="List downloads"/> List downloads</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form autocomplete="off" id="downloads-edit-form" name="downloads-edit-form" method="post" action="downloads-edit.php">
	<table class="data edit">
		<tr class="{cycle values='A,B'}">
			<td class="attribute">File Size:</td>
			<td><input type="text" class="input" name="downloads[file_size]"
			           value="{$downloads.file_size|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats Comments:</td>
			<td><input type="text" class="input" name="downloads[stats_comments]"
			           value="{$downloads.stats_comments|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats HTML:</td>
			<td class="value"><textarea class="editor"
			                            name="downloads[stats_html]">{$downloads.stats_html|htmlentities}</textarea>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats Php:</td>
			<td><input type="text" class="input" name="downloads[stats_php]"
			           value="{$downloads.stats_php|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats Js:</td>
			<td><input type="text" class="input" name="downloads[stats_js]" value="{$downloads.stats_js|htmlentities}"/>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats Css:</td>
			<td><input type="text" class="input" name="downloads[stats_css]"
			           value="{$downloads.stats_css|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats Images:</td>
			<td><input type="text" class="input" name="downloads[stats_images]"
			           value="{$downloads.stats_images|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats Text:</td>
			<td class="value"><textarea class="editor"
			                            name="downloads[stats_text]">{$downloads.stats_text|htmlentities}</textarea>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats Templates:</td>
			<td><input type="text" class="input" name="downloads[stats_templates]"
			           value="{$downloads.stats_templates|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Stats Scripts:</td>
			<td><input type="text" class="input" name="downloads[stats_scripts]"
			           value="{$downloads.stats_scripts|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Show Links:</td>
			<td><input type="text" class="input" name="downloads[show_links]"
			           value="{$downloads.show_links|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Show Samples:</td>
			<td><input type="text" class="input" name="downloads[show_samples]"
			           value="{$downloads.show_samples|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Distribution Link:</td>
			<td><input type="text" class="input" name="downloads[distribution_link]"
			           value="{$downloads.distribution_link|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Distribution Title:</td>
			<td><input type="text" class="input" name="downloads[distribution_title]"
			           value="{$downloads.distribution_title|htmlentities}"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Distribution Text:</td>
			<td class="value"><textarea class="textarea"
			                            name="downloads[distribution_text]">{$downloads.distribution_text|htmlentities}</textarea>
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
				<input type="hidden" name="distribution_id" value="{$downloads.distribution_id}"/>
				<!-- This is different than system's protection code. This is related to particular ID. -->
				<input type="hidden" name="protection_code" value="{$downloads.code}"/> <input type="hidden"
				                                                                               name="edit-action"
				                                                                               value="Edit downloads"/>
				<input type="submit" name="submit-button" class="submit" value="Save Changes"/> Or, <a
					href="{\common\url::last_page('downloads-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
{* Edit validation *}
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/downloads/edit.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of downloads Edit -->