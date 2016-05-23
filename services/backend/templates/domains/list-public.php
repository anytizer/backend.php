<!--{*
Created on: 2011-02-14 12:48:48 850
*}-->
<table class="data" id="data-table">
	<caption>List of Domains</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>Domain Name</th>
		<th>URL Local</th>
		<th>URL Live</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$domainss}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td>
			<a href="domains-details-public.php?id={$domainss[l].domain_id}&amp;code={$domainss[l].code}">{$domainss[l].domain_name}</a>
		</td>
		<td><a href="{$domainss[l].url_local}"><img src="images/hands/026.png" width="22" height="18" alt=""
		                                            title="{$domainss[l].url_local|htmlentities}"/></a></td>
		<td><a href="{$domainss[l].url_live}"><img src="images/hands/027.png" width="22" height="18" alt=""
		                                           title="{$domainss[l].url_live|htmlentities}"/></a></td>
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
<!-- End of domains List (Public) -->