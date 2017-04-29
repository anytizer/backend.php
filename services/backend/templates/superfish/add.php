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
<form autocomplete="off" id="superfish-add-form" name="superfish-add-form" method="post" action="superfish-add.php">
    <table class="data">
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Subdomain ID:</td>
            <td><input name="superfish[subdomain_id]" type="text" class="input" id="superfish[subdomain_id]"
                       value="{$superfish.subdomain_id|htmlentities}"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Context:</td>
            <td>
                <select name="superfish[context]"
                        id="superfish-context"> {html_options options='system:superfish-context'|dropdown
                    selected=$superfish.context} </select>
            </td>
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
                                                                                                value="Add Menus"/>
                <input type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
                    href="{\common\url::last_page('superfish-list.php')}">Cancel</a>
            </td>
        </tr>
    </table>
</form>
<!-- Add validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/superfish/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of superfish Add -->