<!--{*
Created on: 2011-04-06 14:42:31 485
*}-->
{if $messagess|count}
<table class="data" id="data-table">
	<caption>List of Messages</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>*message_id*</th>
		<!--{* Column Headers *}-->
		<th>Message Code</th>
		<th>Message Status</th>
		<th>Message Body</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$messagess}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td>
			<a href="messages-details-public.php?id={$messagess[l].message_id}&amp;code={$messagess[l].code}">{$messagess[l].message_id}</a>
		</td>
		<!--{* Column Data *}-->
		<td>{$messagess[l].message_code}</td>
		<td>{$messagess[l].message_status}</td>
		<td>{$messagess[l].message_body}</td>
	</tr>
	{sectionelse}
	<tr class="error">
		<td>-</td>
		<td>-</td>
		<!--{* Empty Cells *}-->
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

			{* Empty FOOT Cells *}
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
	Jump to page:
	<!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' ' ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
{else}
<div class="nodata">No records.</div>
{/if}
<!-- End of messages List (Public) -->