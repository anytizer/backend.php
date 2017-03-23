<table class="data">
    <thead>
    <tr>
        <th align="right" width="50">S.N.</th>
        <th align="right" width="50">ID</th>
        <th>Subdomain</th>
        <th align="right" width="50">Pages</th>
    </tr>
    </thead>
    <tbody>
    {section name='s' loop=$stats}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.s.index_next}.</td>
        <td class="r"><em>{$stats[s].subdomain_id}</em></td>
        <td>{$stats[s].subdomain|www:false}</td>
        <td class="r"><strong>{$stats[s].pages}</strong></td>
    </tr>
    {/section}
    </tbody>
</table>