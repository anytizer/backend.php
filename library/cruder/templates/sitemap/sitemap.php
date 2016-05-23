<div class="sitemap">
	{section name='s' loop=$sitemap}
	<h2>{$smarty.section.s.index_next}.
		<a href="{c_url}/{$sitemap[s].n}" title="{$sitemap[s].n}">{$sitemap[s].t|ucwords}</a></h2>
	{sectionelse}
	<h2>No pages registered for sitemap.</h2>
	{/section}
</div>