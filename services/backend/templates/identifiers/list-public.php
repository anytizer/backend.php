<!--{*
Created on: 2011-03-18 13:20:47 198
*}-->
<table class="data" id="data-table">
    <caption>List of Identifiers</caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>Context</th>
        <th>Code</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$identifierss}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>
            <a href="identifiers-details-public.php?id={$identifierss[l].identifier_id}&amp;code={$identifierss[l].code}">{$identifierss[l].identifier_context}</a>
        </td>
        <td>
            <a href="identifiers-details-public.php?id={$identifierss[l].identifier_id}&amp;code={$identifierss[l].code}">{$identifierss[l].identifier_code}</a>
        </td>
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
<!-- End of identifiers List (Public) -->