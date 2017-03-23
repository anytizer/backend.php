<!--{*
#__DEVELOPER-COMMENTS__

Created on: __TIMESTAMP__
*}-->
<div class="top-action">
    <ul class="links">
        <li><a href="__ENTITY__-list.php">List __ENTITY_FULLNAME__</a></li>
    </ul>
</div>
<div class="form-wrap">
    <form autocomplete="off" id="__ENTITY__-add-form" name="__ENTITY__-add-form" method="post"
          action="__ENTITY__-add.php"
          enctype="multipart/form-data">
        <table class="data-editor">
            __TR__
            <tr class="{cycle values='A,B'}">
                <td class="attribute">&nbsp;</td>
                <td>
                    <input type="text" name="email" value="" class="vanish"/> <input type="text" name="is_spam" value=""
                                                                                     class="vanish"/>
                    <!--{* 100% sure, only spammers fill these fields, Leave it blank/CSS hidden. *}-->
                    <input type="hidden" name="protection_code" value="{$protection_code}"/> <input type="hidden"
                                                                                                    name="add-action"
                                                                                                    value="Add __ENTITY_FULLNAME__"/>
                    <input type="submit" name="submit-button" class="submit" value="Add"/> <a
                        href="{\common\url::last_page('__ENTITY__-list.php')}" class="button-cancel">Cancel</a>
                </td>
            </tr>
        </table>
    </form>
</div>
<!-- End of administrators __ENTITY__ Add -->
<!-- Add validation -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
<script type="text/javascript" src="js/validators/__ENTITY__/add.js"></script>
<!--{if 0|local}-->
<!-- populates sample data on the form -->
<script type="text/javascript" src="js/validators/__ENTITY__/populate.js"></script>
<!--{/if}-->
<!-- Rich Editor: Remove if not necessary. Or, use different .js files -->
<script type="text/javascript" src="{cdn editor='tinymce'}"></script>
<script type="text/javascript" src="js/tinymce-textareas.js"></script>
<!-- End of __ENTITY__ Add -->