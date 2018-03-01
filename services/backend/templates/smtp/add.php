<!-- Created on: 2010-10-06 12:53:18 781 -->
<div class="information">
    <ul>
        <li><a href="smtp-list.php"><img src="{'table'|icon}"/> List SMTP</a></li>
    </ul>
</div>
<form id="smtp-add-form" name="smtp-add-form" method="post" action="smtp-add.php">
    <table class="data">
        <!--{*
            "Auto Generated" list of columns. Please adjust according to your needs.
            Remove [ smtp_id ] in the list.
        *}-->
        <tr>
            <td class="attribute">sub-domain ID:</td>
            <td>
                <select name="smtp[subdomain_id]">
                    <option value="">-- Choose a sub-domain --</option>
                    {html_options options='system:subdomains_available'|dropdown selected=$smtp.subdomain_id} </select>
            </td>
        </tr>
        <tr>
            <td class="attribute">SMTP Identifier:</td>
            <td><input type="text" class="input" name="smtp[smtp_identifier]"
                       value="{$smtp.smtp_identifier|htmlentities}"/> Unique Identification
            </td>
        </tr>
        <tr>
            <td class="attribute">Host:</td>
            <td><input type="text" class="input" name="smtp[smtp_host]" value="{$smtp.smtp_host|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">Port:</td>
            <td><input type="text" class="input" name="smtp[smtp_port]" value="{$smtp.smtp_port|htmlentities}"/> <span
                    id="smtp-ports"><a href="#">25</a>, <a href="#">26</a>, <a href="#">443</a>, <a href="#">465</a>, <a
                        href="#">587</a>, <a href="#">2525</a>, ...</td>
        </tr>
        <tr>
            <td class="attribute">Authenticate:</td>
            <td>
                <input type="text" class="input" id="smtp-do_authenticate" name="smtp[do_authenticate]"
                       value="{$smtp.do_authenticate|htmlentities}"/> Y/N only (<a href="#" id="put-Y">Yes</a> / <a
                    href="#" id="put-N">No</a>)
            </td>
        </tr>
        <tr>
            <td class="attribute">Username:</td>
            <td><input type="text" class="input" name="smtp[smtp_username]" value="{$smtp.smtp_username|htmlentities}"/>
            </td>
        </tr>
        <tr>
            <td class="attribute">Password:</td>
            <td><input type="text" class="input" name="smtp[smtp_password]" value="{$smtp.smtp_password|htmlentities}"/>
            </td>
        </tr>
        <tr>
            <td class="attribute">From Name:</td>
            <td><input type="text" class="input" name="smtp[from_name]" value="{$smtp.from_name|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">From Email:</td>
            <td><input type="text" class="input" name="smtp[from_email]" value="{$smtp.from_email|htmlentities}"/></td>
        </tr>
        <tr>
            <td class="attribute">Reply-To Name:</td>
            <td><input type="text" class="input" name="smtp[replyto_name]" value="{$smtp.replyto_name|htmlentities}"/>
            </td>
        </tr>
        <tr>
            <td class="attribute">Reply-To Email:</td>
            <td><input type="text" class="input" name="smtp[replyto_email]" value="{$smtp.replyto_email|htmlentities}"/>
            </td>
        </tr>
        <tr>
            <td class="attribute">Comments:</td>
            <td><input type="text" class="input" name="smtp[smtp_comments]" value="{$smtp.smtp_comments|htmlentities}"/>
            </td>
        </tr>
        <tr>
            <td class="attribute">&nbsp;</td>
            <td>
                <input type="text" name="is_spam" value="" style="display:none; visibility:hidden;"/>
                <!--{* only spammers fill this, Leave blank. *}-->
                <input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
                                                                                                name="add-action"
                                                                                                value="Add smtp"/>
                <input type="submit" name="submit-button" class="submit" value="Add"/> Or, <a
                    href="smtp-list.php">Cancel</a></td>
        </tr>
    </table>
</form>
{* Add validation *}
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/smtp/add.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of smtp Add -->