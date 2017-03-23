<!--{*
Created on: 2010-12-27 11:38:12 391
*}-->
<table class="data" id="data-table">
    <caption>List of entries in history</caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>History Title</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$historys}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>
            <a href="history-details-public.php?id={$historys[l].history_id}&amp;code={$historys[l].code}">{$historys[l].history_title}</a>
        </td>
    </tr>
    {sectionelse}
    <tr class="error">
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
<!-- End of history List (Public) -->