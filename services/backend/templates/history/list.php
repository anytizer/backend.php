<!--{*
Created on: 2010-12-27 11:38:12 391
*}-->
<div class="information">
    <ul class="links">
        <li><a href="history-add.php"><img src="{'add'|icon}" title="Add history" alt="Add history"/> Add history</a>
        </li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form method="post" action="history-search.php">
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
<table class="data" id="data-table">
    <caption>List of entries in history</caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Delete</th>
        <th>Subdomain</th>
        <th>Added On</th>
        <th>History Title</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$historys}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td><a class="delete"
               href="history-delete.php?id={$historys[l].history_id}&amp;code={$historys[l].code}">{icon
                name='delete'}</a>
        </td>
        <td>{$historys[l].subdomain_id}</td>
        <td>{$historys[l].added_on|ymd:20}</td>
        <td>
            <a href="history-details.php?id={$historys[l].history_id}&amp;code={$historys[l].code}">{$historys[l].history_title}</a>
        </td>
        <!--{* Management Icons, without being wrapped anymore *}-->
        <td class="nowrap">
            <a class="edit"
               href="history-edit.php?id={$historys[l].history_id}&amp;code={$historys[l].code}">{icon name='edit'}</a>
        </td>
    </tr>
    {sectionelse}
    <tr class="error">
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    {/section}
    </tbody>
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page:
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
{* Handlers, Ajax, Validators *}
<!-- Javascript Validators -->
{js src='validators/history/list.js' validator=true}
<!-- End of history List -->