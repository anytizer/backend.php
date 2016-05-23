<!--{*
#__DEVELOPER-COMMENTS__

Created on: __TIMESTAMP__
*}-->
<div class="search-form">
	<form autocomplete="off" method="post" action="__ENTITY__-search-public.php" name="__ENTITY__-livesearch"
	      id="__ENTITY__-livesearch-form">
		<div class="search-bar">
			<input type="text" name="search___ENTITY__" value="{$search___ENTITY__}" id="search___ENTITY__"
			       class="search-field"/> <input type="submit" name="search-button" value="Search" class="submit"/>
		</div>
		<div id="livesearch-results"></div>
	</form>
</div>
{if $__ENTITY__s|count}
<table class="data" id="data-table">
	<!--{* <caption>List of __ENTITY_FULLNAME__</caption> *}-->
	<thead>
	<tr class="thead">
		<th>S.N.</th>
		<th>Details</th>
		<!--{* Column Headers *}-->        __COLUMN_HEADERS__
	</tr>
	</thead>
	<tbody>
	<!-- __ENTITY__-details-public.php __SINGULAR__.php -->{section name='l' loop=$__ENTITY__s}
	<tr class="{cycle values='A,B'}">
		<td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
		<td><a href="__SINGULAR__.php?id={$__ENTITY__s[l].__PK_NAME__}&amp;code={$__ENTITY__s[l].code}">Details</a></td>
		<!--{* Column Data *}-->        __COLUMN_DATA__
	</tr>
	{sectionelse}
	<tr class="error">
		<td>-</td>
		<td>-</td>
		<!--{* Empty Cells *}-->        __COLUMN_EMPTY__
	</tr>
	{/section}
	</tbody>
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
	<span class="introduction">Jump to page: </span>
	<!--{* wrap with <ul>...</ul> tags when using ulli=true parameter. *}-->    <!--{* <ul> *}-->    {paginate separator=' ' ulli=false source=$pagination}    <!--{* <ul> *}-->
</div>
{/if}
{else}
<div class="nodata">No records.</div>
{/if}
<!-- End of __ENTITY__ List (Public) -->