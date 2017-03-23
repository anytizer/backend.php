<table class="data" id="data-table">
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Page Name</th>
        <th>Active?</th>
        <th>Login?</th>
        <th>Admin?</th>
        <th>Error?</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$permissionss}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>{$permissionss[l].full_name}</td>
        <td>{$permissionss[l].crud_name}</td>
        <td>{$permissionss[l].table_name}</td>
        <td>{$permissionss[l].table_name}</td>
        <td>{$permissionss[l].table_name}</td>
    </tr>
    {sectionelse}
    <tr class="error">
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    {/section}
    </tbody>
</table>
