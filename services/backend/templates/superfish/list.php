<!-- Beginning of superfish list -->
<!--{*
Created on: 2011-02-02 00:36:55 983
*}-->
<div class="information">
    <ul class="links">
        <li><a href="superfish-add.php"><img src="{'add'|icon}" title="Add superfish" alt="Add Menus"/> Add Menus</a>
        </li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form autocomplete="off" method="post" action="superfish-search.php">
	<table>
		<tr>
			<th>Name</th>
			<th>Comments</th>
			<th>&nbsp;</th>
		</tr>
		<tr>
			<td><input type="text" name="search[name]" style="width:200px;" /></td>
			<td><input type="text" name="search[comments]" style="width:200px;" /></td>
			<td><input type="submit" name="search-button" value="Search" class="submit" /></td>
		</tr>
	</table>
</form>
</div>
*}-->
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page:
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<form autocomplete="off" id="superfish-list-form" name="superfish-list-form" method="post"
      action="superfish-blockaction.php">
    <table class="data" id="data-table">
        <caption>List of Menus</caption>
        <thead>
        <tr class="thead">
            <th><input type="checkbox" id="superfish-checkall" name="checkallentities" value="checkallentities"/></th>
            <th>S.N.</th>
            <th>Delete</th>
            <!--{* Column Headers *}-->
            <th>Context</th>
            <th>ID</th>
            <th>Link</th>
            <th>Sort</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        {section name='l' loop=$superfishs}
        <tr class="{cycle values='A,B'}">
            <td class="r"><input type="checkbox" name="superfish[]" value="{$superfishs[l].menu_id}"/></td>
            <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
            <td><a class="delete"
                   href="superfish-delete.php?id={$superfishs[l].menu_id}&amp;code={$superfishs[l].code}">{icon
                    name='delete'}</a>
            </td>
            <!--{* Column Data *}-->
            <td>{$superfishs[l].context}</td>
            <td>{$superfishs[l].menu_id}</td>
            <td>
                <a href="superfish-details.php?id={$superfishs[l].menu_id}&amp;code={$superfishs[l].code}">{$superfishs[l].menu_link}</a>
            </td>
            <td>
                <a class="edit"
                   href="superfish-sort.php?id={$superfishs[l].menu_id}&amp;direction=up">{icon name='up'}</a> <a
                    class="edit"
                    href="superfish-sort.php?id={$superfishs[l].menu_id}&amp;direction=down">{icon name='down'}</a></td>
            <!--{* Management Icons, without being wrapped anymore *}-->
            <td class="nowrap">
                <a class="edit"
                   href="superfish-edit.php?id={$superfishs[l].menu_id}&amp;code={$superfishs[l].code}">{icon
                    name='edit'}</a>
            </td>
        </tr>
        {sectionelse}
        <tr class="error">
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <!--{* Empty Cells *}-->
            <td>-</td>
            <td>&nbsp;</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        {/section}
    </table>
    <div class="block-actions">
        With selected, <input type="hidden" name="action" value="nothing"/> <select name="actions" id="actions">
            <!-- {* Your options will be copied to "action" *}-->
            <option value="disable">Disable</option>
            <option value="enable">Enable</option>
            <option value="delete">Delete</option>
            <option value="prune">Prune</option>
            <option value="nothing" selected="selected">Nothing</option>
        </select> <input type="submit" name="submit-button" id="submit-button" value="Perform!"/>
    </div>
</form>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    <span class="paginator-notice">Jump to page:</span> {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<!-- Handlers, Ajax, Validators -->
<!-- Javascript Validators -->
{js src='validators/superfish/list.js' validator=true}
<!-- End of superfish List -->