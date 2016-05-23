<!-- Beginning of emails list -->
<!--{*
Created on: 2011-03-23 11:38:46 911
*}-->
<div class="information">
	<ul class="links">
		<li><a href="emails-add.php"><img src="{'add'|icon}" title="Add emails" alt="Add Emails"/> Add Emails</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form autocomplete="off" method="post" action="emails-search.php">
	<table>
		<tr>
			<th>Name</th>
			<th>Comments</th>
			<th>&nbsp;</th>
		</tr>
		<tr>
			<td><input type="text" name="search[name]" value="" style="width:200px;" /></td>
			<td><input type="text" name="search[comments]" value="" style="width:200px;" /></td>
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
<form id="emails-list-form" name="emails-list-form" method="post" action="emails-blockaction.php">
	<table class="data" id="data-table">
		<!--{* <caption>List of Emails</caption> *}-->
		<thead>
		<tr class="thead">
			<th><input type="checkbox" id="emails-checkall" name="checkallentities" value="checkallentities"/></th>
			<th class="th-sn">S.N.</th>
			<th class="th-delete">?</th>
			<th>Subdomain</th>
			<th>Code</th>
			<!--{* Column Headers *}-->
			<th>Email Subject</th>
			<th class="th-menus">?</th>
		</tr>
		</thead>
		<tbody>
		{section name='l' loop=$emailss}
		<tr class="{cycle values='A,B'}">
			<td><input type="checkbox" name="emails[]" value="{$emailss[l].email_id}"/></td>
			<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
			<td><a class="delete"
			       href="emails-delete.php?id={$emailss[l].email_id}&amp;code={$emailss[l].code}">{icon name='delete'}</a>
			</td>
			<td>{$emailss[l].subdomain_id}</td>
			<td>
				<a href="emails-details.php?id={$emailss[l].email_id}&amp;code={$emailss[l].code}">{$emailss[l].email_code}</a>
			</td>
			<!--{* Column Data *}-->
			<td>{$emailss[l].email_subject}</td>
			<!--{* Management Icons, without being wrapped anymore *}-->
			<td class="nowrap">
				<!--
							<a class="edit" href="emails-sort.php?id={$emailss[l].email_id}&amp;direction=up">{icon name='up'}</a>
							<a class="edit" href="emails-sort.php?id={$emailss[l].email_id}&amp;direction=down">{icon name='down'}</a>
				-->
				<a class="edit"
				   href="emails-edit.php?id={$emailss[l].email_id}&amp;code={$emailss[l].code}">{icon name='edit'}</a>
			</td>
		</tr>
		{sectionelse}
		<tr class="error">
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>&nbsp;</td>
			<!--{* Empty Cells *}-->
			<td>-</td>
			<td>-</td>
			<td>-</td>
		</tr>
		{/section}
	</table>
	<div class="block-actions">
		<!--{*
			With selected, <input type="hidden" name="action" value="nothing" />
			<select name="actions" id="actions">
				<option value="delete">Delete</option>
				<option value="disable">Disable</option>
				<option value="enable">Enable</option>
				<option value="prune">Prune</option>
				<option value="nothing" selected="selected">Nothing</option>
			</select>
			<input type="submit" name="submit-button" id="submit-button" value="Perform!" />
		*}-->
	</div>
</form>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	<span class="paginator-notice">Jump to page:</span> {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<!-- Handlers, Ajax, Validators -->
<!-- Javascript Validators -->
{js src='validators/emails/list.js' validator=true}
<!-- End of emails List -->