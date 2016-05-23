<div class="information">
	<ul>
		<li>Currently appears in sitemap? <span class="error">{$details.in_sitemap|yesno}</span>. <a
				href="pages-sitemap.php?id={$details.page_id}">Reset Sitemap</a>.
		</li>
	</ul>
</div>
<p>This file is <strong>{$details.page_name}</strong>. ID: {$details.page_id}.</p>
<p>Visit real URL: <a href="{$details.page_id|url}">{$details.page_id|url|truncate:100}</a></p>
<form name="page-editor-form" method="post" action="?">
	<table class="data edit">
		<tr class="meta-block">
			<td class="attribute">Page Title:</td>
			<td><input name="page[page_title]" type="text" value="{$details.page_title}"
			           class="input"/> Appears in &lt;title&gt;...&lt;/title&gt; tag
			</td>
		</tr>
		<tr class="meta-block">
			<td class="attribute">Meta Keywords:</td>
			<td><input name="page[meta_keywords]" type="text" value="{$details.meta_keywords}"
			           class="input"/> Appears as meta keywords
			</td>
		</tr>
		<tr class="meta-block">
			<td class="attribute">Meta Description:</td>
			<td><input name="page[meta_description]" type="text" value="{$details.meta_description}"
			           class="input"/> Appears as meta description
			</td>
		</tr>
		<tr class="meta-block">
			<td class="attribute">Content Heading:</td>
			<td><input name="page[content_title]" type="text" value="{$details.content_title}"
			           class="input"/> Appears as content heading
			</td>
		</tr>
		<tr>
			<td class="attribute">Contents:</td>
			<td><textarea name="page[content_text]" class="editor">{$details.content_text|htmlentities}</textarea></td>
		</tr>
		<tr>
			<td class="attribute">Included File:</td>
			<td><input name="page[include_file]" type="text" value="{$details.include_file}"
			           class="input"/> What file to import after the contents?
			</td>
		</tr>
		<tr>
			<td class="attribute">Template:</td>
			<td><input name="page[template_file]" type="text" value="{$details.template_file}" class="input"/></td>
		</tr>
		<tr>
			<td class="attribute">&nbsp;</td>
			<td><input type="hidden" name="page-id" value="{$smarty.get.pi}"/> <input type="submit" name="save-action"
			                                                                          value="Save file"
			                                                                          class="submit"/> or <a
					href="{\common\url::last_page('pages-list.php')}">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
<script type="text/javascript" src="js/validators/pages/edit.js"></script>
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>