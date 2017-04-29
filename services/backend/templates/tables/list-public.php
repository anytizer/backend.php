<!-- Created on: 2010-06-11 02:19:25 152 -->
<table class="data" id="data-table">
    <caption align="top">
        List of system tables allowed to export
    </caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Table Name</th>
        {* Column Headers *}
        <th>Table Comments</th>
        <th>Structure?</th>
        <th> Data?</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
    {section name='l' loop=$tabless}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>
            <a href="tables-details-public.php?id={$tabless[l].table_id}&code={$tabless[l].code}">{$tabless[l].table_name}</a>
        </td>
        {* Column Data *}
        <td>{$tabless[l].table_comments}</td>
        <td>
            <a href="tables-flag.php?id={$tabless[l].table_id}&amp;field=structure">{$tabless[l].export_structure|yn}</a>
        </td>
        <td><a href="tables-flag.php?id={$tabless[l].table_id}&amp;field=data">{$tabless[l].export_data|yn}</a></td>
    </tr>
    {sectionelse}
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    {/section}
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page: {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<!-- End of tables List (Public) -->