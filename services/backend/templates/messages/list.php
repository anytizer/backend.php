<!-- Beginning of messages list -->
<!--{*
Created on: 2011-04-06 14:42:31 485
*}-->
<div class="information">
	<ul class="links">
		<li><a href="messages-add.php"><img src="{'add'|icon}" title="Add messages"
		                                    alt="Add Messages"/> Add Messages</a></li>
	</ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form method="post" action="messages-search.php" name="messages-livesearch" id="messages-livesearch">
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
	<div id="livesearch-results"></div>
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
<form id="messages-list-form" name="messages-list-form" method="post" action="messages-blockaction.php">
	<table class="data" id="data-table">
		<!--{* <caption>List of Messages</caption> *}-->
		<thead>
		<tr class="thead">
			<th><input type="checkbox" id="messages-checkall" name="checkallentities" value="checkallentities"/></th>
			<th class="th-sn">S.N.</th>
			<th class="th-delete">?</th>
			<th>Subdomain</th>
			<th>Code</th>
			<!--{* Column Headers *}-->
			<th>Status</th>
			<th>Message</th>
			<th class="th-menus">Actions</th>
		</tr>
		</thead>
		<tbody>
		{section name='l' loop=$messagess}
		<tr class="{cycle values='A,B'}">
			<td><input type="checkbox" name="messages[]" value="{$messagess[l].message_id}"/></td>
			<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
			<td><a class="delete"
			       href="messages-delete.php?id={$messagess[l].message_id}&amp;code={$messagess[l].code}">{icon name='delete'}</a>
			</td>
			<td>{$messagess[l].subdomain_id}</td>
			<td>
				<a href="messages-details.php?id={$messagess[l].message_id}&amp;code={$messagess[l].code}">{$messagess[l].message_code}</a>
			</td>
			<!--{* Column Data *}-->
			<td>{$messagess[l].message_status}</td>
			<td>{$messagess[l].message_body}</td>
			<!--{* Management Icons, without being wrapped anymore *}-->
			<td class="nowrap">
				<a class="edit"
				   href="messages-edit.php?id={$messagess[l].message_id}&amp;code={$messagess[l].code}">{icon name='edit'}</a>
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
<!-- Javascript Handlers, Ajax, and Validators -->
{js src='ajax.js'}
{js src='validators/messages/list.js' validator=true}
<!-- End of messages List -->