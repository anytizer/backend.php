<!--{*
Created on: 2010-12-14 00:48:38 194
*}-->
<table class="data" id="data-table">
	<caption>List of entries in downloads</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>*distribution_id*</th>
		<!--{* Column Headers *}-->
		<th>File Size</th>
		<th>Stats Comments</th>
		<th>Stats Php</th>
		<th>Stats Js</th>
		<th>Stats Css</th>
		<th>Stats Images</th>
		<th>Stats Templates</th>
		<th>Stats Scripts</th>
		<th>Show Links</th>
		<th>Show Samples</th>
		<th>Distribution Link</th>
		<th>Distribution Title</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$downloadss}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td>
			<a href="downloads-details-public.php?id={$downloadss[l].distribution_id}&amp;code={$downloadss[l].code}">{$downloadss[l].distribution_id}</a>
		</td>
		<!--{* Column Data *}-->
		<td>{$downloadss[l].file_size}</td>
		<td>{$downloadss[l].stats_comments}</td>
		<td>{$downloadss[l].stats_php}</td>
		<td>{$downloadss[l].stats_js}</td>
		<td>{$downloadss[l].stats_css}</td>
		<td>{$downloadss[l].stats_images}</td>
		<td>{$downloadss[l].stats_templates}</td>
		<td>{$downloadss[l].stats_scripts}</td>
		<td>{$downloadss[l].show_links}</td>
		<td>{$downloadss[l].show_samples}</td>
		<td>{$downloadss[l].distribution_link}</td>
		<td>{$downloadss[l].distribution_title}</td>
	</tr>
	{sectionelse}
	<tr class="error">
		<td>-</td>
		<td>-</td>
		<!--{* Empty Cells *}-->
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
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

			{* Empty FOOT Cells *}
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
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
	Jump to page:
	<!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' ' ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<!-- End of downloads List (Public) -->