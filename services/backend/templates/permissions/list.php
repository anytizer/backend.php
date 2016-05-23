<!-- Beginning of permissions list -->
<!--{*
Created on: 2011-03-29 23:48:23 316
*}-->
<div class="information">
	<ul class="links">
		<li><a href="permissions-add.php"><img src="{'add'|icon}" title="Add permissions"
		                                       alt="Add Entity Permissions"/> Add Entity Permissions</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form method="post" action="permissions-search.php">
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
<form id="permissions-list-form" name="permissions-list-form" method="post" action="permissions-blockaction.php">
	<table class="data" id="data-table">
		<!--{* <caption>List of Entity Permissions</caption> *}-->
		<thead>
		<tr class="thead">
			<th><input type="checkbox" id="permissions-checkall" name="checkallentities" value="checkallentities"/></th>
			<th class="th-sn">S.N.</th>
			<th class="th-delete">?</th>
			<th>Subdomain</th>
			<th>CRUD Entity</th>
			<th>Name</th>
			<!--{* Column Headers *}-->
			<th>Table Name / PK Name</th>
			<th class="th-menus">Sort/Actions</th>
		</tr>
		</thead>
		<tbody>
		{section name='l' loop=$permissionss}
		<tr class="{cycle values='A,B'}">
			<td><input type="checkbox" name="permissions[]" value="{$permissionss[l].crud_id}"/></td>
			<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
			<td><a class="delete"
			       href="permissions-delete.php?id={$permissionss[l].crud_id}&amp;code={$permissionss[l].code}">{icon name='delete'}</a>
			</td>
			<td>{$permissionss[l].subdomain_id|subdomain}</td>
			<td>{$permissionss[l].crud_name}</td>
			<td>
				<a href="permissions-details.php?id={$permissionss[l].crud_id}&amp;code={$permissionss[l].code}">{$permissionss[l].crud_name}</a>
			</td>
			<td>{$permissionss[l].table_name} =&gt; {$permissionss[l].pk_name}</td>
			<td class="nowrap">
				{* <a class="edit"
				      href="permissions-sort.php?id={$permissionss[l].crud_id}&amp;direction=up">{icon name='up'}</a> <a
					class="edit"
					href="permissions-sort.php?id={$permissionss[l].crud_id}&amp;direction=down">{icon name='down'}</a> *}
				<a class="edit"
				   href="permissions-edit.php?id={$permissionss[l].crud_id}&amp;code={$permissionss[l].code}">{icon name='edit'}</a>
				<a class="permissions"
				   href="permissions-matrix.php?id={$permissionss[l].crud_id}&amp;code={$permissionss[l].code}">{icon name='permissions'}</a>
			</td>
		</tr>
		{sectionelse}
		<tr class="error">
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>&nbsp;</td>
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
{js src='validators/permissions/list.js' validator=true}
<!-- End of permissions List -->