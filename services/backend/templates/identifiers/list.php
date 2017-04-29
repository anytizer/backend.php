<!-- Beginning of identifiers list -->
<!--{*
Created on: 2011-03-18 13:20:47 198
*}-->
<div class="information">
    <ul class="links">
        <li><a href="identifiers-add.php"><img src="{'add'|icon}" title="Add identifiers"
                                               alt="Add Identifiers"/> Add Identifiers</a></li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form method="post" action="identifiers-search.php">
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
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<form id="identifiers-list-form" name="identifiers-list-form" method="post" action="identifiers-blockaction.php">
    <table class="data" id="data-table">
        <!--{* <caption>List of Identifiers</caption> *}-->
        <thead>
        <tr class="thead">
            <th><input type="checkbox" id="identifiers-checkall" name="checkallentities" value="checkallentities"/></th>
            <th class="th-sn">S.N.</th>
            <th class="th-delete">?</th>
            <!--{* Column Headers *}-->
            <th>Identifier Context</th>
            <th>Identifier Code</th>
            <th class="th-menus">Sort/Actions</th>
        </tr>
        </thead>
        <tbody>
        {section name='l' loop=$identifierss}
        <tr class="{cycle values='A,B'}">
            <td><input type="checkbox" name="identifiers[]" value="{$identifierss[l].identifier_id}"/></td>
            <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
            <td><a class="delete"
                   href="identifiers-delete.php?id={$identifierss[l].identifier_id}&amp;code={$identifierss[l].code}">{icon
                    name='delete'}</a>
            </td>
            <!--{* Column Data *}-->
            <td>{$identifierss[l].identifier_context}</td>
            <td>
                <a href="identifiers-details.php?id={$identifierss[l].identifier_id}&amp;code={$identifierss[l].code}">{$identifierss[l].identifier_code}</a>
            </td>
            <!--{* Management Icons, without being wrapped anymore *}-->
            <td class="nowrap">
                <a class="edit"
                   href="identifiers-edit.php?id={$identifierss[l].identifier_id}&amp;code={$identifierss[l].code}">{icon
                    name='edit'}</a>
            </td>
        </tr>
        {sectionelse}
        <tr class="error">
            <td>-</td>
            <td>-</td>
            <td>-</td>
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
{js src='validators/identifiers/list.js' validator=true}
<!-- End of identifiers List -->