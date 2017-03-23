<!--{*
Created on: 2010-12-14 00:48:38 194
*}-->
<div class="information">
    <ul class="links">
        <li><a href="downloads-add.php"><img src="{'add'|icon}" title="Add downloads"
                                             alt="Add downloads"/> Add downloads</a></li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form autocomplete="off" method="post" action="downloads-search.php">
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
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<table class="data" id="data-table">
    <caption>List of entries in downloads</caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Delete</th>
        <th>*distribution_id*</th>
        <!--{* Column Headers *}-->
        <th>File Size</th>
        <th>Stats Comments</th>
        <th>Stats Php</th>
        <th>Stats Js</th>
        <th>Stats Css</th>
        <th>Stats Images</th>
        <th>Stats Templates</th>
        <th>Stats Scripts</th>
        <th>Show Links</th>
        <th>Show Samples</th>
        <th>Distribution Link</th>
        <th>Distribution Title</th>
        <th>Sort</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$downloadss}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td><a class="delete"
               href="downloads-delete.php?id={$downloadss[l].distribution_id}&amp;code={$downloadss[l].code}">{icon
                name='delete'}</a>
        </td>
        <td>
            <a href="downloads-details.php?id={$downloadss[l].distribution_id}&amp;code={$downloadss[l].code}">{$downloadss[l].distribution_id}</a>
        </td>
        <!--{* Column Data *}-->
        <td>{$downloadss[l].file_size}</td>
        <td>{$downloadss[l].stats_comments}</td>
        <td>{$downloadss[l].stats_php}</td>
        <td>{$downloadss[l].stats_js}</td>
        <td>{$downloadss[l].stats_css}</td>
        <td>{$downloadss[l].stats_images}</td>
        <td>{$downloadss[l].stats_templates}</td>
        <td>{$downloadss[l].stats_scripts}</td>
        <td>{$downloadss[l].show_links}</td>
        <td>{$downloadss[l].show_samples}</td>
        <td>{$downloadss[l].distribution_link}</td>
        <td>{$downloadss[l].distribution_title}</td>
        <td>
            <a class="edit"
               href="downloads-sort.php?id={$downloadss[l].distribution_id}&amp;direction=up">{icon name='up'}</a> <a
                class="edit"
                href="downloads-sort.php?id={$downloadss[l].distribution_id}&amp;direction=down">{icon name='down'}</a>
        </td>
        <!--{* Management Icons, without being wrapped anymore *}-->
        <td class="nowrap">
            <a class="edit"
               href="downloads-edit.php?id={$downloadss[l].distribution_id}&amp;code={$downloadss[l].code}">{icon
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
        <td>-</td>
        <td>-</td>
        <td>-</td>
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
    <!--
    <tfoot>
        <tr>
            <td>-</td>
            <td>-</td>
            <td>-</td>

            {* Empty FOOT Cells *}
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>

            <td>-</td>
            <td>-</td>
        </tr>
    </tfoot>
    -->
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page:
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
{* Handlers, Ajax, Validators *}
<!-- Javascript Validators -->
{js src='validators/downloads/list.js' validator=true}
<!-- End of downloads List -->