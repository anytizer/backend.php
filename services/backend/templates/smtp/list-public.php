<!-- Created on: 2010-10-06 12:53:18 781 -->
<table class="data" id="data-table">
    <caption>
        List of entries in SMTP
    </caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Identifier</th>
        <th>Host Name</th>
        <th>Username</th>
        <th>&lt;From Name&gt;</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$smtps}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>
            <a href="smtp-details-public.php?id={$smtps[l].smtp_id}&code={$smtps[l].code}">{$smtps[l].smtp_identifier|truncate:10}</a>
        </td>
        <td>{$smtps[l].smtp_host|truncate:15}</td>
        <td>{$smtps[l].smtp_username|truncate:15}</td>
        <td>{$smtps[l].from_name}</td>
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
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page: {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<!-- End of smtp List (Public) -->