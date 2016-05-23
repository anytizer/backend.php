<!--{*
Created on: 2011-02-09 23:32:47 349
*}-->
<div class="information">
	<ul class="links">
		<li><a href="cms-list.php"><img src="{'table'|icon}" title="List CMS" alt="List CMS"/> List CMS</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form autocomplete="off" id="cms-add-form" name="cms-add-form" method="post" action="cms-add.php">
	<table class="data">
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Page Name:</td>
			<td><input type="text" name="cms[page_name]" value="{$cms.page_name|htmlentities}" class="input"
			           id="cms-page_name"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Page Title:</td>
			<td><input type="text" name="cms[page_title]" value="{$cms.page_title|htmlentities}" class="input"
			           id="cms-page_title"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Include File:</td>
			<td><input type="text" name="cms[include_file]" value="{$cms.include_file|htmlentities}" class="input"
			           id="cms-include_file"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Content Title:</td>
			<td><input type="text" name="cms[content_title]" value="{$cms.content_title|htmlentities}" class="input"
			           id="cms-content_title"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Content Text:</td>
			<td class="value"><textarea rows="5" cols="50" name="cms[content_text]" class="editor"
			                            id="cms-content_text">{$cms.content_text|htmlentities}</textarea></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Meta Keywords:</td>
			<td><input type="text" name="cms[meta_keywords]" value="{$cms.meta_keywords|htmlentities}" class="input"
			           id="cms-meta_keywords"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Meta Description:</td>
			<td class="value"><textarea rows="5" cols="50" name="cms[meta_description]" class="editor"
			                            id="cms-meta_description">{$cms.meta_description|htmlentities}</textarea></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Template File:</td>
			<td><input type="text" name="cms[template_file]" value="{$cms.template_file|htmlentities}" class="input"
			           id="cms-template_file"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Page Comments:</td>
			<td><input type="text" name="cms[page_comments]" value="{$cms.page_comments|htmlentities}" class="input"
			           id="cms-page_comments"/></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Page Extra:</td>
			<td><input type="text" name="cms[page_extra]" value="{$cms.page_extra|htmlentities}" class="input"
			           id="cms-page_extra"/></td>
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
				                                                                                value="Add CMS"/> <input
					type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
					href="{\common\url::last_page('cms-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<!-- Add validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/cms/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of cms Add -->