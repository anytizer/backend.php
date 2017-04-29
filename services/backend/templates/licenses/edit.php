<!--{*
Created on: 2011-02-10 00:12:27 318
*}-->
<div class="information">
    <ul class="links">
        <li><a href="licenses-list.php"><img src="{'table'|icon}" title="List License" alt="List License"/> List License</a>
        </li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<form id="licenses-edit-form" name="licenses-edit-form" method="post" action="licenses-edit.php">
    <table class="data edit">
        <!-- file or image upload script/patch --><!--{*
	<tr class="{cycle values='A,B'} waring-overwrite">
		<td class="attribute">licenses File/Picture:</td>
		<td>
			<input type="file" name="licensesfile" id="licensesfile" value="" />
			<a href="{$licenses.licensesfile}" target="preview">View current</a>
		</td>
	</tr>
*}-->
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Application Name:</td>
            <td><input type="text" name="licenses[application_name]" value="{$licenses.application_name|htmlentities}"
                       class="input" id="licenses-application_name"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Server Name:</td>
            <td><input type="text" name="licenses[server_name]" value="{$licenses.server_name|htmlentities}"
                       class="input" id="licenses-server_name"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">Protection Key:</td>
            <td><input type="text" name="licenses[protection_key]" value="{$licenses.protection_key|htmlentities}"
                       class="input" id="licenses-protection_key"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">License Key:</td>
            <td><input type="text" name="licenses[license_key]" value="{$licenses.license_key|htmlentities}"
                       class="input" id="licenses-license_key"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">License Email:</td>
            <td><input type="text" name="licenses[license_email]" value="{$licenses.license_email|htmlentities}"
                       class="input" id="licenses-license_email"/></td>
        </tr>
        <tr class="{cycle values='A,B'}">
            <td class="attribute">License To:</td>
            <td><input type="text" name="licenses[license_to]" value="{$licenses.license_to|htmlentities}" class="input"
                       id="licenses-license_to"/></td>
        </tr>
        <tr>
            <td class="attribute">&nbsp;</td>
            <td>
                <input type="text" name="email" value="" style="display:none; visibility:hidden;"/> <input type="text"
                                                                                                           name="is_spam"
                                                                                                           value=""
                                                                                                           style="display:none; visibility:hidden;"/>
                <!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
                <input type="hidden" name="license_id" value="{$licenses.license_id}"/>
                <!-- This is different than system's protection code. This is related to particular ID. -->
                <input type="hidden" name="protection_code" value="{$licenses.code}"/> <input type="hidden"
                                                                                              name="edit-action"
                                                                                              value="Edit License"/>
                <input type="submit" name="submit-button" class="submit" value="Save Changes"/> Or, <a
                    href="{\common\url::last_page('licenses-list.php')}">Cancel</a>
            </td>
        </tr>
    </table>
</form>
<!-- Validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
{js src='validators/licenses/edit.js' validator=true}
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of licenses Edit -->