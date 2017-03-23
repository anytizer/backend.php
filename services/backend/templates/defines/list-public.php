<!-- Created on: 2010-06-16 21:19:04 969 -->
<table class="data" id="data-table">
    <caption align="top">List of entries in defines</caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Context</th>
        <th>Name</th>
        <th>Value</th>
        <th>Comments</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$definess}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>{$definess[l].define_context}</td>
        <td>{$definess[l].define_name}</td>
        <td>{$definess[l].define_value}</td>
        <td>{$definess[l].define_comments}</td>
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
    </tbody>
    <!--
    <tfoot>
        <tr>
            <td>-</td>
            <td>-</td>
        </tr>
    </tfoot>
    -->
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page: {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<!-- End of defines List (Public) -->