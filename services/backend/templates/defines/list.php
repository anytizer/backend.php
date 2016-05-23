<!-- Created on: 2010-06-16 21:19:04 969 -->
<div class="information">
	<ul>
		<li><a href="defines-add.php"><img src="{'add'|icon}"/> Add defines</a></li>
	</ul>
</div>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	Jump to page: {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<table class="data" id="data-table">
	<caption align="top">
		List of defined contexts
	</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>?</th>
		<th>Context</th>
		<th>Name</th>
		<th>Value</th>
		<th>Handler</th>
		<th>?</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$definess}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td><a class="delete"
		       href="defines-delete.php?id={$definess[l].define_id}&code={$definess[l].code}">{icon name='delete'}</a>
		</td>
		<td>{$definess[l].define_context}</td>
		<td><a href="defines-edit.php?id={$definess[l].define_id}&amp;code={$definess[l].code}"
		       title="{$definess[l].define_comments|htmlentities}">{$definess[l].define_name}</a></td>
		<td>{$definess[l].define_value}</td>
		<td>{$definess[l].define_handler}</td>
		<td>
			<a class="edit"
			   href="defines-edit.php?id={$definess[l].define_id}&code={$definess[l].code}">{icon name='edit'}</a>
		</td>
	</tr>
	{sectionelse}
	<tr>
		<td>-</td>
		<td>-</td>
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
{js src='validators/defines/list.js' validator=true}
<!-- End of defines List -->