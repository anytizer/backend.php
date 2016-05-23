<!-- Created on: 2010-11-15 13:36:42 243 -->
<table class="data" id="data-table">
	<caption>List of entries in cdn</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>Name</th>
		<th>MIME</th>
		<th>Remote Link</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$cdns}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td><a href="cdn-details-public.php?id={$cdns[l].cdn_id}&code={$cdns[l].code}">{$cdns[l].cdn_name}</a></td>
		<td>{$cdns[l].cdn_mime}</td>
		<td>{$cdns[l].cdn_remote_link}</td>
	</tr>
	{sectionelse}
	<tr class="error">
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
	<!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' ' ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<!-- End of cdn List (Public) -->