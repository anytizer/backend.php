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
<form id="messages-edit-form" name="messages-edit-form" method="post" action="messages-edit.php">
    <table class="data-editor">
        <!-- file or image upload script/patch --><!--{*
	<tr class="{cycle values='A,B'} waring-overwrite">
		<td class="attribute">messages File/Picture:</td>
		<td>
			<input type="file" name="messagesfile" id="messagesfile" value="" />
			<a href="{$messages.messagesfile}" target="preview">View current</a>
		</td>
	</tr>
*}-->
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Message Code:</td>
            <td>{$messages.message_code}</td>
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
        <tr>
            <td class="attribute">&nbsp;</td>
            <td>
                <input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
                                                                                 class="vanish"/>
                <!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
                <input type="hidden" name="message_id" value="{$messages.message_id}"/>
                <!-- This is different than system's protection code. This is related to particular ID. -->
                <input type="hidden" name="protection_code" value="{$messages.code}"/> <input type="hidden"
                                                                                              name="edit-action"
                                                                                              value="Edit Messages"/>
                <input type="submit" name="submit-button" class="submit" value="Save Changes"/> <a
                    href="{\common\url::last_page('messages-list.php')}" class="button-cancel">Cancel</a></td>
        </tr>
    </table>
</form>
<!-- Validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/messages/edit.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of messages Edit -->