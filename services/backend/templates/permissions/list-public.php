<!--{*
Created on: 2011-03-29 23:48:23 316
*}-->
<table class="data" id="data-table">
    <caption>List of Entity Permissions</caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>CRUD Name</th>
        <th>Full Name</th>
        <th>Table Name</th>
        <th>Pk Name</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$permissionss}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>
            <a href="permissions-details-public.php?id={$permissionss[l].crud_id}&amp;code={$permissionss[l].code}">{$permissionss[l].crud_name}</a>
        </td>
        <td>{$permissionss[l].full_name}</td>
        <td>{$permissionss[l].table_name}</td>
        <td>{$permissionss[l].pk_name}</td>
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
<!-- End of permissions List (Public) -->