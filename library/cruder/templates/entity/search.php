<!-- Beginning of __ENTITY__ list -->
<!--{*
#__DEVELOPER-COMMENTS__

Created on: __TIMESTAMP__
*}-->
<div class="search-form">
	<form autocomplete="off" method="post" action="__ENTITY__-search.php" name="__ENTITY__-livesearch" id="__ENTITY__-livesearch-form">
		<div class="search-bar">
			<input type="text" name="search___ENTITY__" value="{$search___ENTITY__}" id="search___ENTITY__"/> <input
				type="submit" name="search-button" value="Search" class="submit"/>
		</div>
		<div id="livesearch-results"></div>
	</form>
</div>
<div class="top-action">
	<ul class="links">
		<li class="record-add"><a href="__ENTITY__-add.php">Add __ENTITY_FULLNAME__</a></li>
	</ul>
</div>
{if $__ENTITY__s|count}
{if $pagination->has_pages()}
<!-- paginator begins -->
<div class="paginator">
	Jump to page:    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' ' ulli=false source=$pagination}    <!-- </ul> -->
</div>
<!-- paginator ends -->
{/if}
<form id="__ENTITY__-list-form" name="__ENTITY__-list-form" method="post" action="__ENTITY__-blockaction.php">
	<table class="data" id="data-table">
		<!--{* <caption>List of __ENTITY_FULLNAME__</caption> *}-->
		<thead>
		<tr class="thead">
			<th><input type="checkbox" id="__ENTITY__-checkall" name="checkallentities" value="checkallentities"
			           tabindex="0"/></th>
			<th class="th-sn">S.N.</th>
			<th>*__PK_NAME__*</th>
			<!--{* Column Headers *}-->        __COLUMN_HEADERS__
			<th class="th-menus">?</th>
		</tr>
		</thead>
		<tbody>
		{section name='l' loop=$__ENTITY__s}
		<tr class="{cycle values='A,B'}">
			<td><input type="checkbox" name="__ENTITY__[]" value="{$__ENTITY__s[l].__PK_NAME__}"/></td>
			<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
			<td>
				<a href="__ENTITY__-details.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}">{$__ENTITY__s[l].__PK_NAME__}</a>
			</td>
			<!--{* Column Data *}-->        __COLUMN_DATA__
			<!--{* Management Icons, without being wrapped anymore *}-->
			<td class="nowrap">
				<a class="edit"
				   href="__ENTITY__-sort.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;direction=up">{icon name='up'}</a> <a
					class="edit"
					href="__ENTITY__-sort.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;direction=down">{icon name='down'}</a>
				<a class="edit"
				   href="__ENTITY__-edit.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}">{icon name='edit'}</a>
				<a class="delete"
				   href="__ENTITY__-delete.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}">{icon name='delete'}</a>
			</td>
		</tr>
		{sectionelse}
		<tr class="error">
			<td>-</td>
			<td>-</td>
			<!--{* Empty Cells *}-->        __COLUMN_EMPTY__
			<td>-</td>
			<td>-</td>
		</tr>
		{/section}
		</tbody>
	</table>
	<div class="block-actions">
		<!--{*
			With selected records, <input type="hidden" name="action" value="nothing" />
			<select name="actions" id="actions">
				<option value="delete">Delete</option>
				<option value="disable">Disable</option>
				<option value="enable">Enable</option>
				<option value="prune">Prune</option>
				<option value="update">Update</option>
				<option value="nothing" selected="selected">Nothing</option>
			</select>
			<input type="submit" name="submit-button" id="submit-button" value="Perform!" />
		*}-->
	</div>
</form>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	<span class="introduction">Jump to page: </span> {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<!-- Javascript Handlers, Ajax, and Validators -->
{js src='ajax.js'}
{js src='validators/__ENTITY__/list.js' validator=true}
{else}
<div class="nodata">No records.</div>
{/if}
<!-- End of __ENTITY__ List -->