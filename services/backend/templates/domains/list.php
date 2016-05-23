<!-- Beginning of domains list -->
<!--{*
Created on: 2011-02-14 12:48:48 850
*}-->
<div class="information">
	<ul class="links">
		<li><a href="domains-add.php"><img src="{'add'|icon}" title="Add domains" alt="Add Domains"/> Add Domains</a>
		</li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form autocomplete="off" method="post" action="domains-search.php">
	<table>
		<tr>
			<th>Name</th>
			<th>Comments</th>
			<th>&nbsp;</th>
		</tr>
		<tr>
			<td><input type="text" name="search[name]" value="" style="width:200px;" /></td>
			<td><input type="text" name="search[comments]" value="" style="width:200px;" /></td>
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
	<!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' ' ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<form autocomplete="off" id="domains-list-form" name="domains-list-form" method="post" action="domains-blockaction.php">
	<table class="data" id="data-table">
		<!--{* <caption>List of Domains</caption> *}-->
		<thead>
		<tr class="thead">
			<th><input type="checkbox" id="domains-checkall" name="checkallentities" value="checkallentities"/></th>
			<th class="th-sn">S.N.</th>
			<th class="th-delete">?</th>
			<th>Domain Name</th>
			<!--{* Column Headers *}-->
			<th>URLs</th>
			<th class="th-menus">Actions</th>
		</tr>
		</thead>
		<tbody>
		{section name='l' loop=$domainss}
		<tr class="{cycle values='A,B'}">
			<td><input type="checkbox" name="domains[]" value="{$domainss[l].domain_id}"/></td>
			<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
			<td><a class="delete"
			       href="domains-delete.php?id={$domainss[l].domain_id}&amp;code={$domainss[l].code}">{icon name='delete'}</a>
			</td>
			<td>
				<a href="domains-details.php?id={$domainss[l].domain_id}&amp;code={$domainss[l].code}">{$domainss[l].domain_name}</a>
			</td>
			<!--{* Column Data *}-->
			<td>
				<a href="{$domainss[l].url_local}"><img src="images/hands/026.png" width="22" height="18" alt="Local"
				                                        title="Local: {$domainss[l].url_local|htmlentities}"/></a> <a
					href="{$domainss[l].url_live}"><img src="images/hands/027.png" width="22" height="18" alt="Live"
				                                        title="Live: {$domainss[l].url_live|htmlentities}"/></a></td>
			<!--{* Management Icons, without being wrapped anymore *}-->
			<td class="nowrap">
				<a class="edit"
				   href="domains-sort.php?id={$domainss[l].domain_id}&amp;direction=up">{icon name='up'}</a> <a
					class="edit"
					href="domains-sort.php?id={$domainss[l].domain_id}&amp;direction=down">{icon name='down'}</a> <a
					class="edit"
					href="domains-edit.php?id={$domainss[l].domain_id}&amp;code={$domainss[l].code}">{icon name='edit'}</a>
			</td>
		</tr>
		{sectionelse}
		<tr class="error">
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<!--{* Empty Cells *}-->
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
{js src='validators/domains/list.js' validator=true}
<!-- End of domains List -->