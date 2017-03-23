<!--{*
Created on: 2011-03-23 11:38:46 911
*}-->
<table class="data" id="data-table">
    <caption>List of Emails</caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Email Code</th>
        <th>Email Subject</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$emailss}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>
            <a href="emails-details-public.php?id={$emailss[l].email_id}&amp;code={$emailss[l].code}">{$emailss[l].email_code}</a>
        </td>
        <td>{$emailss[l].email_subject}</td>
    </tr>
    {sectionelse}
    <tr class="error">
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
<!-- End of emails List (Public) -->