<!--{*
Created on: 2011-02-02 00:36:55 983
*}-->
<table class="data" id="data-table">
	<caption>List of Menus</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>Context</th>
		<th>Menu Text</th>
		<th>Menu Link</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$superfishs}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td>{$superfishs[l].context}</td>
		<td>
			<a href="superfish-details-public.php?id={$superfishs[l].menu_id}&amp;code={$superfishs[l].code}">{$superfishs[l].menu_text}</a>
		</td>
		<td>{$superfishs[l].menu_link}</td>
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
<!-- End of superfish List (Public) -->