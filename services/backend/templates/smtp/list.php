<!-- Created on: 2010-10-06 12:53:18 781 -->
<div class="information">
	<ul>
		<li><a href="smtp-add.php"><img src="{'add'|icon}"/> Add SMTP</a></li>
	</ul>
</div>
<!--{*
<div class="search-form">
<form method="post" action="smtp-search.php">
	<table>
		<tr>
			<th>Name</th>
			<th>Comments</th>
			<th>&nbsp;</th>
		</tr>
		<tr>
			<td><input type="text" name="search[name]" style="width:200px;" /></td>
			<td><input type="text" name="search[comments]" style="width:200px;" /></td>
			<td><input type="submit" name="search-button" value="Search" class="submit" /></td>
		</tr>
	</table>
</form>
</div>
*}-->
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	Jump to page: {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<table class="data" id="data-table">
	<caption>
		List of entries in SMTP
	</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>Delete</th>
		<th>Subdomain</th>
		<th>Identifier</th>
		<th>Host Name</th>
		<th>Username</th>
		<th>Comments</th>
		<th>Edit</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$smtps}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td><a class="delete"
		       href="smtp-delete.php?id={$smtps[l].smtp_id}&amp;code={$smtps[l].code}">{icon name='delete'}</a></td>
		<td>{$smtps[l].subdomain_id}</td>
		<td><a href="smtp-details.php?id={$smtps[l].smtp_id}&code={$smtps[l].code}"
		       title="{$smtps[l].smtp_identifier|htmlentities}">{$smtps[l].smtp_identifier|truncate:20}</a></td>
		<td>{$smtps[l].smtp_host|truncate:20}</td>
		<td>{$smtps[l].smtp_username|truncate:20}</td>
		<td>{$smtps[l].smtp_comments|truncate:20}</td>
		<td class="nowrap">
			<a class="delete" href="smtp-delete.php?id={$smtps[l].smtp_id}&code={$smtps[l].code}"></a> <a class="edit"
			                                                                                              href="smtp-edit.php?id={$smtps[l].smtp_id}&code={$smtps[l].code}">{icon name='edit'}</a>
		</td>
	</tr>
	{sectionelse}
	<tr>
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
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	Jump to page: {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
{* Handlers, Ajax, Validators *}
<!-- Javascript Validators -->
{js src='validators/smtp/list.js' validator=true}
<!-- End of smtp List -->