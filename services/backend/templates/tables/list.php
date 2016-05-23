<!-- Created on: 2010-06-11 02:19:25 152 -->
<div class="information">
	<ul>
		<li><a href="tables-add.php"><img src="{'add'|icon}"/> Add tables</a></li>
	</ul>
</div>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	Jump to page: {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<table class="data" id="data-table">
	<caption align="top">List of entries in tables</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>Delete</th>
		<th>Table Name</th>
		{* Column Headers *}
		<th>Comments</th>
		<th>Export Structure?</th>
		<th>Export Data?</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$tabless}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td><a class="delete"
		       href="tables-delete.php?id={$tabless[l].table_id}&amp;code={$tabless[l].code}">{icon name='delete'}</a>
		</td>
		<td><a href="tables-details.php?id={$tabless[l].table_id}&code={$tabless[l].code}">{$tabless[l].table_name}</a>
		</td>
		{* Column Data *}
		<td>{$tabless[l].table_comments}</td>
		<td>{$tabless[l].export_structure|yn}</td>
		<td>{$tabless[l].export_data|yn}</td>
		<td class="nowrap">
			<a class="delete" href="tables-delete.php?id={$tabless[l].table_id}&code={$tabless[l].code}"></a> <a
				class="edit"
				href="tables-edit.php?id={$tabless[l].table_id}&code={$tabless[l].code}">{icon name='edit'}</a>
		</td>
	</tr>
	{sectionelse}
	<tr>
		<td>-</td>
		<td>&nbsp;</td>
		<td>-</td>
		{* Empty Cells *}
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
	</tr>
	{/section}
	</tbody>
	<!--
	<tfoot>
		<tr>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
		</tr>
	</tfoot>
	-->
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	Jump to page: {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
{* Handlers, Ajax, Validators *}
<!-- Javascript Validators -->
{js src='validators/tables/list.js' validator=true}
<!-- End of tables List -->