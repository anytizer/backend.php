<table class="data">
    <thead>
    <tr>
        <th>S.N.</th>
        <th>Contexts / Sort</th>
        <th>Counter</th>
    </tr>
    </thead>
    <tbody>
    {section name='c' loop=$contexts}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.c.index_next}.</td>
        <td><a href="menus-sort.php?context={$contexts[c].mc|urlencode}">{$contexts[c].mc}</a></td>
        <td>{$contexts[c].counter} {'menu'|plural:$contexts[c].counter}</td>
    </tr>
    {sectionelse}
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    {/section}
</table>
