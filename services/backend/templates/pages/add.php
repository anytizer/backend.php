<form name="page-add-form" method="post" action="?">
    <table>
        <tr>
            <td class="attribute">Subdomain:</td>
            <td>
                <select name="page[subdomain_id]">
                    <option value="">-- Choose a subdomain --</option>
                    {html_options options='system:services'|dropdown selected='subdomain_id'|magical} </select>
            </td>
        </tr>
        <tr>
            <td class="attribute">Page Name:</td>
            <td><input name="page[page_name]" type="text" value="{$details.page_name}" class="input"/>

                <p>Page status: <span id="page-valid-message">N/A <img src="{'help'|icon}" width="16"
                                                                       height="16"/></span></p>
            </td>
        </tr>
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
        <tr>
            <td class="attribute">Content Heading:</td>
            <td><input name="page[content_title]" type="text" value="{$details.content_title}"
                       class="input"/> Appears as content heading
            </td>
        </tr>
        <tr>
            <td class="attribute">Contents:</td>
            <td><textarea name="page[content_text]" class="editor">{$details.content_text|htmlentities}</textarea></td>
        </tr>
        <tr class="meta-block">
            <td class="attribute">Included File:</td>
            <td><input name="page[include_file]" type="text" value="{$details.include_file}"
                       class="input"/> What file to import after the contents?
            </td>
        </tr>
        <tr>
            <td class="attribute">&nbsp;</td>
            <td>
                <input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
                                                                                                name="add-action"
                                                                                                value="Add Page"/>
                <input type="submit" name="submit-button" value="Save" class="submit"/> or <a
                    href="{\common\url::last_page('pages-list.php')}">Cancel</a></td>
        </tr>
    </table>
</form>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
<script type="text/javascript" src="js/validators/pages/add.js"></script>
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>