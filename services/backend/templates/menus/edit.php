<!-- Created on: 2009-11-11 20:01:53 711 -->
<style type="text/css">
    <!--
    td.attribute {
        white-space: nowrap;
    }

    -->
</style>
<table>
    <tr>
        <td>
            <form id="menus-edit-form" name="menus-edit-form" method="post" action="menus-edit.php">
                <table class="data edit">
                    <tr>
                        <td class="attribute">Context:</td>
                        <td><input type="text" class="input" name="menus[menu_context]" value="{$menus.menu_context}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="attribute">Menu Text:</td>
                        <td><input type="text" class="input" name="menus[menu_text]" value="{$menus.menu_text}"/></td>
                    </tr>
                    <tr>
                        <td class="attribute">Links to:</td>
                        <td><input type="text" class="input" name="menus[menu_link]" value="{$menus.menu_link}"/></td>
                    </tr>
                    <tr>
                        <td class="attribute">Target:</td>
                        <td><input type="text" class="input" name="menus[link_target]" value="{$menus.link_target}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="attribute">ALT Tag:</td>
                        <td><input type="text" class="input" name="menus[html_alt]" value="{$menus.html_alt}"/></td>
                    </tr>
                    <tr>
                        <td class="attribute">TITLE Tag:</td>
                        <td><input type="text" class="input" name="menus[html_title]" value="{$menus.html_title}"/></td>
                    </tr>
                    <tr>
                        <td class="attribute">HTML Class:</td>
                        <td><input type="text" class="input" name="menus[html_class]" value="{$menus.html_class}"/></td>
                    </tr>
                    <tr>
                        <td class="attribute">HTML ID:</td>
                        <td><input type="text" class="input" name="menus[html_id]" value="{$menus.html_id}"/></td>
                    </tr>
                    <tr>
                        <td class="attribute">&nbsp;</td>
                        <td><input type="hidden" name="menus_id" value="{$menus.menu_id}"/>
                            <!-- This is different than system's protection code. This is related to particular ID. -->
                            <input type="hidden" name="protection_code" value="{$menus.code}"/> <input type="hidden"
                                                                                                       name="edit-action"
                                                                                                       value="Edit menus"/>
                            <input type="submit" name="submit-button" class="submit" value="Edit"/> or <a
                                href="menus-list.php">Cancel</a></td>
                    </tr>
                </table>
            </form>
        </td>
        <td>{include file='menus/inc.contexts.php'}</td>
    </tr>
</table>
{* Edit validation *}
{js src='validators/menus/edit.js' validator=true}