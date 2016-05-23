<!-- Beginning of __ENTITY__ list -->
<!--{*
#__DEVELOPER-COMMENTS__

Created on: __TIMESTAMP__
*}-->
<div class="search-form">
	<form autocomplete="off" method="post" action="__ENTITY__-search.php" name="__ENTITY__-livesearch" id="__ENTITY__-livesearch-form">
		<div class="search-bar">
			<input type="text" name="search___ENTITY__" value="{$search___ENTITY__}" id="search___ENTITY__" class="search-field"/> <input type="submit" name="search-button" value="Search" class="submit"/>
			<a href="__ENTITY__-list.php">Cancel</a>
		</div>
		<div id="livesearch-results"></div>
	</form>
</div>
<div class="top-action">
	<ul class="links">
		<li class="record-list"><a href="__ENTITY__-list.php?random={random}">Refresh</a></li>
		<li class="record-add"><a href="__ENTITY__-add.php">Add __ENTITY_FULLNAME__</a></li>
	</ul>
</div>
{if $__ENTITY__s|count}
<div class="form-wrap">
	<form id="__ENTITY__-list-form" name="__ENTITY__-list-form" method="post" action="__ENTITY__-blockaction.php">
		<table class="data" id="data-table">
			<!--{* <caption>List of __ENTITY_FULLNAME__</caption> *}-->
			<thead>
			<tr class="thead">
				<th class="checkboxes"><input type="checkbox" id="__ENTITY__-checkall" name="checkallentities" value="checkallentities" tabindex="0"/></th>
				<th title="Serial Number" class="th-sn">S.N.</th>
				<th title="Enable/Disable viewing this record">{#WHATTITLE#}</th>
				<th>Details</th>
				<!--{* Column Headers *}--> 
				__COLUMN_HEADERS__
				<th title="Other administrative options and actions on this record" class="th-menus">{#EDITTITLE#}</th>
			</tr>
			</thead>
			<tbody>
			{section name='l' loop=$__ENTITY__s}
			<tr class="{cycle values='A,B'}">
				<td class="checkboxes"><input type="checkbox" name="__ENTITY__[]" value="{$__ENTITY__s[l].__PK_NAME__}"/></td>
				<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
				<td>
					<a class="ajax" href="__ENTITY__-flag.php?ajax=true&amp;flag=is_approved&amp;id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}">{$__ENTITY__s[l].is_approved|yn}</a>
				</td>
				<td>
					<a href="__ENTITY__-details.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}">Details</a>
				</td>
				<!--{* Column Data *}-->        __COLUMN_DATA__
				<!--{* Management Icons, without being wrapped anymore *}-->
				<td class="actions nowrap">
					<ul>
						<li class="edit"><a
								href="__ENTITY__-edit.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}"
								title="Edit">Edit</a></li>
						<!--{*
						<li class="move-up"><a href="__ENTITY__-sort.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}&amp;direction=up" title="Move Up">Move Up</a></li>
						<li class="move-down"><a href="__ENTITY__-sort.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}&amp;direction=down" title="Move Down">Move Down</a></li>
						<li class="detail"><a href="__ENTITY__-details.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}" title="Details">Details</a></li>
						<li class="delete"><a href="__ENTITY__-delete.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}" title="Delete" class="delete">Delete</a></li>
						*}-->
					</ul>
				</td>
			</tr>
			{sectionelse}
			<tr class="error">
				<td class="checkboxes">-</td>
				<td>-</td>
				<td>-</td>
				<!--{* Empty FOOTER Cells *}-->        __COLUMN_EMPTY__
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
					<option value="">-- Choose --</option>
					<option value="delete">Delete</option>
					<option value="disable">Disable</option>
					<option value="enable">Enable</option>
					<option value="prune">Prune</option>
					<option value="update">Update</option>
					<option value="nothing" selected="selected">Do Nothing</option>
				</select>
				<input type="submit" name="submit-button" id="submit-button" value="Perform!" />
			*}-->
		</div>
	</form>
</div>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	<span class="introduction">Jump to page: </span> {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<!-- Javascript Handlers, Ajax, and Validators -->
<script src="js/ajax.js" type="text/javascript"></script>
{js src='validators/__ENTITY__/list.js' validator=true}
{else}
<div class="nodata">No records.</div>
{/if}
<!-- End of __ENTITY__ List -->