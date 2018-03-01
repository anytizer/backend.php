<!--{*
Created on: 2011-04-06 14:42:31 485
*}-->
<div class="information">
    <ul class="links">
        <li><a href="messages-list.php"><img src="{'table'|icon}" title="List Messages"
                                             alt="List Messages"/> List Messages</a></li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form id="messages-add-form" name="messages-add-form" method="post" action="messages-add.php">
    <table class="data-editor">
        <tr class="{cycle values='A,B'}">
            <td class="attribute">sub-domain ID: <span class="required">*</span></td>
            <td><select name="messages[subdomain_id]">
                    <option value="">-- Choose a sub-domain --</option>
                    {html_options options='system:services'|dropdown selected=$defines.subdomain_id} </select></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Message Status: <span class="required">*</span></td>
            <td><select name="messages[message_status]"
                        id="messages-message_status">{html_options options=$status
                    selected=$messages.message_status}</select>
            </td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Message Body: <span class="required">*</span></td>
            <td><textarea name="messages[message_body]" class="editor"
                          id="messages-message_body">{$messages.message_body|htmlentities}</textarea></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Comments:</td>
            <td><input type="text" name="messages[message_comments]" id="textfield" value=""/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">&nbsp;</td>
            <td>
                <input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
                                                                                 class="vanish"/>
                <!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
                <input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
                                                                                                name="add-action"
                                                                                                value="Add Messages"/>
                <input type="submit" name="submit-button" class="submit" value="Add"/> <a
                    href="{\common\url::last_page('messages-list.php')}" class="button-cancel">Cancel</a></td>
        </tr>
    </table>
</form>
<!-- Add validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/messages/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of messages Add -->