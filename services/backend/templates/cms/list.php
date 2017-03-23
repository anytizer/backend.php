<!-- Beginning of cms list -->
<!--{*
Created on: 2011-02-09 23:32:47 349
*}-->
<div class="information">
    <ul class="links">
        <li><a href="cms-add.php"><img src="{'add'|icon}" title="Add cms" alt="Add CMS"/> Add CMS</a></li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<div class="search-form">
    <form autocomplete="off" method="post" action="cms-search.php">
        <table>
            <tr>
                <td><input type="text" name="search[name]" style="width:200px;"/></td>
                <td><input type="submit" name="search-button" value="Search" class="submit"/></td>
            </tr>
        </table>
    </form>
    <div id="livesearch-cms"></div>
</div>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page:
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<form autocomplete="off" id="cms-list-form" name="cms-list-form" method="post" action="cms-blockaction.php">
    <table class="data" id="data-table">
        <caption>List of CMS</caption>
        <thead>
        <tr class="thead">
            <th><input type="checkbox" id="cms-checkall" name="checkallentities" value="checkallentities"/></th>
            <th>S.N.</th>
            <th>Delete</th>
            <th>Page Name</th>
            <!--{* Column Headers *}-->
            <th>Page Title</th>
            <th>Template File</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        {section name='l' loop=$cmss}
        <tr class="{cycle values='A,B'}">
            <td><input type="checkbox" name="cms[]" value="{$cmss[l].page_id}"/></td>
            <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
            <td><a class="delete"
                   href="cms-delete.php?id={$cmss[l].page_id}&amp;code={$cmss[l].code}">{icon name='delete'}</a></td>
            <td><a href="cms-details.php?id={$cmss[l].page_id}&amp;code={$cmss[l].code}">{$cmss[l].page_name}</a></td>
            <!--{* Column Data *}-->
            <td>{$cmss[l].page_title}</td>
            <td>{$cmss[l].template_file}</td>
            <td nowrap="nowrap">
                <a class="edit" href="cms-sort.php?id={$cmss[l].page_id}&amp;direction=up">{icon name='up'}</a> <a
                    class="edit" href="cms-sort.php?id={$cmss[l].page_id}&amp;direction=down">{icon name='down'}</a> <a
                    class="edit"
                    href="cms-edit.php?id={$cmss[l].page_id}&amp;code={$cmss[l].code}">{icon name='edit'}</a></td>
            <!--{* Management Icons, without being wrapped anymore *}-->
        </tr>
        {sectionelse}
        <tr class="error">
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <!--{* Empty Cells *}-->
            <td>-</td>
            <td>-</td>
            <td>--</td>
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
{js src='validators/cms/list.js' validator=true}
<!-- End of cms List -->