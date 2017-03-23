<!--{*
#__DEVELOPER-COMMENTS__

Created on: __TIMESTAMP__
*}-->
<div class="top-action">
    <ul class="links">
        <li class="record-list"><a href="__ENTITY__-list.php">List __ENTITY_FULLNAME__</a></li>
    </ul>
</div>
<div class="form-wrap">
    <form autocomplete="off" id="__ENTITY__-edit-form" name="__ENTITY__-edit-form" method="post"
          action="__ENTITY__-edit.php"
          enctype="multipart/form-data">
        <table class="data-editor">
            __TR__
            <tr>
                <td class="attribute">&nbsp;</td>
                <td>
                    <input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
                                                                                     class="vanish"/>
                    <!--{* 100% sure, only spammers fill these fields, Leave blank. *}-->
                    <input type="hidden" name="__PK_NAME__" value="{$__ENTITY__.__PK_NAME__}"/>
                    <!-- This is different than system's protection code. This is related to particular ID. -->
                    <input type="hidden" name="protection_code" value="{$__ENTITY__.code}"/> <input type="hidden"
                                                                                                    name="edit-action"
                                                                                                    value="Edit __ENTITY_FULLNAME__"/>
                    <input type="submit" name="submit-button" class="submit" value="Save Changes"/> <a
                        href="{\common\url::last_page('__ENTITY__-list.php')}" class="button-cancel">Cancel</a>
                </td>
            </tr>
        </table>
    </form>
</div>
<!-- End of administrators Edit -->
<!-- Validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
<script type="text/javascript" src="js/validators/__ENTITY__/edit.js"></script>
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="{cdn editor='tinymce'}"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of __ENTITY__ Edit -->
