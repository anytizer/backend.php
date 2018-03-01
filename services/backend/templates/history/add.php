<!--{*
Created on: 2010-12-27 11:38:12 391
*}-->
<div class="information">
    <ul class="links">
        <li><a href="history-list.php"><img src="{'table'|icon}" title="List history" alt="List history"/> List history</a>
        </li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form id="history-add-form" name="history-add-form" method="post" action="history-add.php">
    <table class="data">
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Subdomain:</td>
            <td><select name="history[subdomain_id]">
                    <option value="">-- Choose a sub-domain --</option>
                    {html_options options='system:services'|dropdown selected='subdomain_id'|magical} </select>
            </td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">History Title:</td>
            <td><input type="text" name="history[history_title]" value="{$history.history_title|htmlentities}"
                       class="input" id="history-history_title"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">History Text:</td>
            <td class="value"><textarea name="history[history_text]" class="editor"
                                        id="history-history_text">{$history.history_text|htmlentities}</textarea></td>
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
                                                                                                value="Add history"/>
                <input type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
                    href="{\common\url::last_page('history-list.php')}">Cancel</a></td>
        </tr>
    </table>
</form>
{* Add validation *}
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/history/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of history Add -->