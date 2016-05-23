<!--{*
Created on: 2011-02-10 00:27:11 536
*}-->
<table class="data" id="data-table">
	<caption>List of Sub-Domains</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>Subdomain Name</th>
		<th>Subdomain Comments</th>
		<th>Subdomain URL</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$subdomainss}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td>
			<a href="subdomains-details-public.php?id={$subdomainss[l].subdomain_id}&amp;code={$subdomainss[l].code}">{$subdomainss[l].subdomain_name}</a>
		</td>
		<td>{$subdomainss[l].subdomain_comments}</td>
		<td>{$subdomainss[l].subdomain_url}</td>
	</tr>
	{sectionelse}
	<tr class="error">
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
	</tr>
	{/section}
	<td height="2">
	</tbody>
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	Jump to page:
	<!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' ' ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<!-- End of subdomains List (Public) -->