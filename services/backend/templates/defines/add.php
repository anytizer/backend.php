<!-- Created on: 2010-06-16 21:19:04 969 -->
<div class="information">
    <ul>
        <li><a href="defines-list.php"><img src="{'table'|icon}"/> List defines</a></li>
    </ul>
</div>
<form autocomplete="off" id="defines-add-form" name="defines-add-form" method="post" action="defines-add.php">
    <table class="data">
        <tr>
            <td class="attribute">Subdomain:</td>
            <td>
                <select name="defines[subdomain_id]">
                    <option value="">-- Choose a subdomain --</option>
                    {html_options options='system:services'|dropdown selected=$defines.subdomain_id} </select>
            </td>
        </tr>
        <tr>
            <td class="attribute">Context:</td>
            <td><input type="text" class="input" name="defines[define_context]"
                       value="{$defines.define_context|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">Name:</td>
            <td><input type="text" class="input" name="defines[define_name]"
                       value="{$defines.define_name|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">Value:</td>
            <td><input type="text" class="input" name="defines[define_value]"
                       value="{$defines.define_value|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">Sample Value:</td>
            <td><input type="text" class="input" name="defines[define_sample]"
                       value="{$defines.define_sample|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">Validation Handler:</td>
            <td><input type="text" class="input" name="defines[define_handler]"
                       value="{$defines.define_handler|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">Comments:</td>
            <td><input type="text" class="input" name="defines[define_comments]"
                       value="{$defines.define_comments|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">&nbsp;</td>
            <td>
                <input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
                                                                                                name="add-action"
                                                                                                value="Add defines"/>
                <input type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
                    href="defines-list.php">Cancel</a></td>
        </tr>
    </table>
</form>
{* Add validation *}
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/defines/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of defines Add -->