<style type="text/css">
	<!--
	.holder
	{
		margin: 10px 0px 0px 0px;
		border: 1px solid #FF0000;
	}

	.meta
	{
		text-align: right;
		padding: 5px;
		background-color: #FFFFCC;
	}

	.description
	{
		font-size: 11px;
		text-align: justify;
		padding: 5px 5px 5px 45px;
	}

	h3
	{
		margin: 0px;
	}

	-->
</style>
<div class="warning">
	<p><strong>Warning</strong>: To run these services, you should have modified your
		<strong>hosts</strong> files locally, pointing to IP:
		<strong>127.0.0.1</strong>. If these sites do not run from a live server, they are either meant for
		<strong>Intranet</strong> or is in development. Below listed subdomains are registered as active sites.</p>

	<p>Distribution of these sites may NOT be puplic.</p>
</div>
{section name='s' loop=$subdomains}
<div class="holder">
	<h3>{$smarty.section.s.index_next}. {$subdomains[s].sn}: {$subdomains[s].sc}</h3>

	<div class="meta">
		<p>Visit <a href="http://{$subdomains[s].sn}/backend/backend/">Local Site</a> | <a
				href="{$subdomains[s].id|subdomain_url}">Live Site</a>, ID: {{$subdomains[s].id}}. This subdomain has {$subdomains[s].pages} {'page'|plural:$subdomains[s].pages}.
		</p>

		<div class="description">{$subdomains[s].sd}</div>
	</div>
</div>
{sectionelse}
<p>All subdomains are disabled at the moment.</p>
{/section}