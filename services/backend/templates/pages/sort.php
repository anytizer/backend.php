<table class="data">
	<thead>
	<tr>
		<th>S.N.</th>
		<th>Weight</th>
		<th>&nbsp;</th>
		<th>Page Name</th>
		<th>Page Title</th>
	</tr>
	</thead>
	<tbody>
	{section name='p' loop=$pagess}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.p.index_next}.</td>
		<td class="r">{$pagess[p].sink_weight}</td>
		<td nowrap="nowrap">
			<a href="?id={$pagess[p].page_id}&direction=up">{icon name='up'}</a> <a
				href="?id={$pagess[p].page_id}&direction=down">{icon name='down'}</a>
		</td>
		<td>{$pagess[p].page_title}</td>
		<td><a href="pages-edit.php?pi={$pagess[p].page_id}&code={$pagess[p].code}">{$pagess[p].page_name}</a></td>
	</tr>
	{/section}
	</tbody>
</table>