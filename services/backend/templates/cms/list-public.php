<!--{*
Created on: 2011-02-09 23:25:11 836
*}-->
<table class="data" id="data-table">
    <caption>
        List of CMS
    </caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Page Name</th>
        <th>Page Title</th>
        <th>Include File</th>
        <th>Template File</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$cmss}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td><a href="cms-details-public.php?id={$cmss[l].page_id}&amp;code={$cmss[l].code}">{$cmss[l].page_name}</a>
        </td>
        <td>{$cmss[l].page_title}</td>
        <td>{$cmss[l].include_file}</td>
        <td>{$cmss[l].template_file}</td>
    </tr>
    {sectionelse}
    <tr class="error">
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    {/section}
    </tbody>
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page:
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<!-- End of cms List (Public) -->