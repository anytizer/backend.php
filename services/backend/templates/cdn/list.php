<!-- Created on: 2010-11-15 13:36:42 243 -->
<div class="information">
	<ul class="links">
		<li><a href="cdn-add.php"><img src="{'add'|icon}" title="Add cdn" alt="Add cdn"/> Add CDN</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form autocomplete="off" method="post" action="cdn-search.php">
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
	Jump to page:
	<!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' ' ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<table class="data" id="data-table">
	<caption>List of entries in cdn</caption>
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>Delete</th>
		<th>Name</th>
		<th>Remote Link</th>
		<th>Version</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
	{section name='l' loop=$cdns}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td><a class="delete" href="cdn-delete.php?id={$cdns[l].cdn_id}&code={$cdns[l].code}">{icon name='delete'}</a>
		</td>
		<td><a href="cdn-details.php?id={$cdns[l].cdn_id}&code={$cdns[l].code}">{$cdns[l].cdn_name}</a></td>
		<td><a href="{$cdns[l].cdn_remote_link}">{$cdns[l].cdn_remote_link|strrev|truncate:40:'...':false|strrev}</a>
		</td>
		<td>{$cdns[l].cdn_version}</td>
		<!--{* Management Icons, without being wrapped anymore *}-->
		<td class="nowrap">
			<a class="edit" href="cdn-edit.php?id={$cdns[l].cdn_id}&code={$cdns[l].code}">{icon name='edit'}</a></td>
	</tr>
	{sectionelse}
	<tr class="error">
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
	Jump to page:
	<!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' ' ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
{* Handlers, Ajax, Validators *}
<!-- Javascript Validators -->
{js src='validators/cdn/list.js' validator=true}
<!-- End of cdn List -->