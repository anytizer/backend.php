<p style="text-align:right; padding-top:10px;">Back to <a href="menus-add.php">Add Menus</a></p>
<table class="data">
	<thead>
	<tr>
		<th>S.N.</th>
		<th>Weight</th>
		<th>Movers</th>
		<th>Menu Text</th>
		<th>Menu Link</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
	{section name='m' loop=$menus}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.m.index_next}.</td>
		<td class="r">{$menus[m].sink_weight}</td>
		<td>
			<a href="?context={$smarty.get.context}&id={$menus[m].menu_id}&direction=up">{icon name='up'}</a> <a
				href="?context={$smarty.get.context}&id={$menus[m].menu_id}&direction=down">{icon name='down'}</a>
		</td>
		<td><strong>{$menus[m].menu_text}</strong></td>
		<td>{$menus[m].menu_link}</td>
		<td><a href="menus-edit.php?id={$menus[m].menu_id}&code={$menus[m].code}">{icon name='edit'}</a></td>
	</tr>
	{/section}
	</tbody>
</table>
<p style="text-align:right; padding-top:10px;">Back to <a href="menus-add.php">Add Menus</a></p>
