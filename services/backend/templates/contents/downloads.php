<table class="data">
    <thead>
    <tr>
        <th>S.N.</th>
        <th>Size</th>
        <th>Product</th>
        <th>Description</th>
        <th>Download</th>
    </tr>
    </thead>
    <tbody>
    {section name='d' loop=$distributions}
    <tr class="{cycle values='A,B'}">
        <td>{$smarty.section.d.index_next}.</td>
        <td>{$distributions[d].file_size|byte_format}</td>
        <td><a href="{$distributions[d].distribution_link}">{$distributions[d].distribution_title}</a></td>
        <td>{$distributions[d].distribution_text}</td>
        <td><a href="?pid={$distributions[d].distribution_id}">Download</a></td>
    </tr>
    {sectionelse}
    <tr class="{cycle values='A,B'}">
        <td>-</td>
        <td>-</td>
        <td>No Downloads available for now</td>
        <td>-</td>
        <td>-</td>
    </tr>
    {/section}
    </tbody>
</table>