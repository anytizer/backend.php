<!-- Beginning of licenses list -->
<!--{*
Created on: 2011-02-10 00:12:27 318
*}-->
<div class="information">
    <ul class="links">
        <li><a href="licenses-add.php"><img src="{'add'|icon}" title="Add licenses" alt="Add License"/> Add License</a>
        </li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form method="post" action="licenses-search.php">
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
<form id="licenses-list-form" name="licenses-list-form" method="post" action="licenses-blockaction.php">
    <table class="data" id="data-table">
        <caption>List of License</caption>
        <thead>
        <tr class="thead">
            <th><input type="checkbox" id="licenses-checkall" name="checkallentities" value="checkallentities"/></th>
            <th>S.N.</th>
            <th>Delete</th>
            <th>*license_id*</th>
            <!--{* Column Headers *}-->
            <th>Application Name</th>
            <th>Server Name</th>
            <th>Protection Key</th>
            <th>License Key</th>
            <th>License Email</th>
            <th>License To</th>
            <th>Sort</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        {section name='l' loop=$licensess}
        <tr class="{cycle values='A,B'}">
            <td><input type="checkbox" name="licenses[]" value="{$licensess[l].license_id}"/></td>
            <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
            <td><a class="delete"
                   href="licenses-delete.php?id={$licensess[l].license_id}&amp;code={$licensess[l].code}">{icon
                    name='delete'}</a>
            </td>
            <td>
                <a href="licenses-details.php?id={$licensess[l].license_id}&amp;code={$licensess[l].code}">{$licensess[l].license_id}</a>
            </td>
            <!--{* Column Data *}-->
            <td>{$licensess[l].application_name}</td>
            <td>{$licensess[l].server_name}</td>
            <td>{$licensess[l].protection_key}</td>
            <td>{$licensess[l].license_key}</td>
            <td>{$licensess[l].license_email}</td>
            <td>{$licensess[l].license_to}</td>
            <td>
                <a class="edit"
                   href="licenses-sort.php?id={$licensess[l].license_id}&amp;direction=up">{icon name='up'}</a> <a
                    class="edit"
                    href="licenses-sort.php?id={$licensess[l].license_id}&amp;direction=down">{icon name='down'}</a>
            </td>
            <!--{* Management Icons, without being wrapped anymore *}-->
            <td class="nowrap">
                <a class="edit"
                   href="licenses-edit.php?id={$licensess[l].license_id}&amp;code={$licensess[l].code}">{icon
                    name='edit'}</a>
            </td>
        </tr>
        {sectionelse}
        <tr class="error">
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <!--{* Empty Cells *}-->
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        {/section}
    </table>
    <div class="block-actions">
        <!--{*
            With selected, <input type="hidden" name="action" value="nothing" />
            <select name="actions" id="actions">
                <option value="delete">Delete</option>
                <option value="disable">Disable</option>
                <option value="enable">Enable</option>
                <option value="prune">Prune</option>
                <option value="nothing" selected="selected">Nothing</option>
            </select>
            <input type="submit" name="submit-button" id="submit-button" value="Perform!" />
        *}-->
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
{js src='validators/licenses/list.js' validator=true}
<!-- End of licenses List -->