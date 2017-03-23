<!--{*
Created on: 2011-02-10 00:12:27 318
*}-->
<table class="data" id="data-table">
    <caption>List of License</caption>
    <thead>
    <tr class="thead">
        <th>S.N.</th>
        <th>*license_id*</th>
        <!--{* Column Headers *}-->
        <th>Application Name</th>
        <th>Server Name</th>
        <th>Protection Key</th>
        <th>License Key</th>
        <th>License Email</th>
        <th>License To</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$licensess}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
        <td>
            <a href="licenses-details-public.php?id={$licensess[l].license_id}&amp;code={$licensess[l].code}">{$licensess[l].license_id}</a>
        </td>
        <!--{* Column Data *}-->
        <td>{$licensess[l].application_name}</td>
        <td>{$licensess[l].server_name}</td>
        <td>{$licensess[l].protection_key}</td>
        <td>{$licensess[l].license_key}</td>
        <td>{$licensess[l].license_email}</td>
        <td>{$licensess[l].license_to}</td>
    </tr>
    {sectionelse}
    <tr class="error">
        <td>-</td>
        <td>-</td>
        <!--{* Empty Cells *}-->
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    {/section}
    </tbody>
    <!--
    <tfoot>
        <tr>
            <td>-</td>
            <td>-</td>

            {* Empty FOOT Cells *}
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
    </tfoot>
    -->
</table>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page:
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<!-- End of licenses List (Public) -->