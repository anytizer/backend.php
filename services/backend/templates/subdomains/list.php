<!-- Beginning of subdomains list -->
<!--{*
Created on: 2011-02-10 00:27:11 536
*}-->
<div class="information">
    <ul class="links">
        <li><a href="subdomains-add.php"><img src="{'add'|icon}" title="Add subdomains"
                                              alt="Add Sub-Domains"/> Add a Sub-Domain</a></li>
        <li><a href="write-hosts-file.php"><img src="{'edit'|icon}"/> Write &quot;hosts&quot; file</a></li>
        <li><a href="install/export/index.php"><img src="images/selected-icons/briefcase.png"/> Export Sub-Domains</a>
        </li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!--{*
<div class="search-form">
<form autocomplete="off" method="post" action="subdomains-search.php">
	<table>
		<tr>
			<th>Name</th>
			<th>Comments</th>
			<th>&nbsp;</th>
		</tr>
		<tr>
			<td><input type="text" name="search[name]" style="width:200px;" /></td>
			<td><input type="text" name="search[comments]" style="width:200px;" /></td>
			<td><input type="submit" name="search-button" value="Search" class="submit" /></td>
		</tr>
	</table>
</form>
</div>
*}-->
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    Jump to page:
    <!-- wrap with <ul>...</ul> tags when using ulli=true parameter. -->    <!-- <ul> -->    {paginate separator=' '
    ulli=false source=$pagination}    <!-- </ul> -->
</div>
{/if}
<div class="entity-search" style="margin-bottom:15px;">
    <form autocomplete="off" method="post" action="?" name="subdomains-livesearch">
        <table>
            <tr>
                <th>Search by name</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <td><input type="text" name="subdomain_name" value="{'subdomain_name'|magical}" style="width:200px;"/>
                </td>
                <td><input type="submit" name="search-button" value="Search" class="submit"/> or, <a
                        href="subdomains-list.php">List all</a>
                </td>
            </tr>
        </table>
        <div id="livesearch-results"></div>
    </form>
</div>
<form autocomplete="off" id="subdomains-list-form" name="subdomains-list-form" method="post"
      action="subdomains-blockaction.php">
    <table class="data" id="data-table">
        <caption>List of Sub-Domains</caption>
        <thead>
        <tr class="thead">
            <th><input type="checkbox" id="subdomains-checkall" name="checkallentities" value="checkallentities"/></th>
            <th>S.N.</th>
            <th>?</th>
            <th>Name</th>
            <!--{* Column Headers *}-->
            <th>Comments</th>
            <th>IP Address</th>
            <th>URL</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        {section name='l' loop=$subdomainss}
        <tr class="{cycle values='A,B'}">
            <td><input type="checkbox" name="subdomains[]" value="{$subdomainss[l].subdomain_id}"/></td>
            <td class="r">{$smarty.section.l.index_next+$pagination->beginning_entry()}.</td>
            <td><a class="delete"
                   href="subdomains-delete.php?id={$subdomainss[l].subdomain_id}&amp;code={$subdomainss[l].code}">{icon
                    name='delete'}</a>
            </td>
            <td>
                <a href="subdomains-details.php?id={$subdomainss[l].subdomain_id}&amp;code={$subdomainss[l].code}">{$subdomainss[l].subdomain_name}</a>
            </td>
            <!--{* Column Data *}-->
            <td>{$subdomainss[l].subdomain_comments}</td>
            <td>{$subdomainss[l].subdomain_ip}</td>
            <td><a href="{$subdomainss[l].subdomain_url}" target="_server{$subdomainss[l].subdomain_id}"><img
                        src="{'point-right'|icon}" width="22" height="18" title="" alt=""/></a></td>
            <td nowrap="nowrap">
                <a class="edit"
                   href="subdomains-sort.php?id={$subdomainss[l].subdomain_id}&amp;direction=up">{icon name='up'}</a> <a
                    class="edit"
                    href="subdomains-sort.php?id={$subdomainss[l].subdomain_id}&amp;direction=down">{icon
                    name='down'}</a>
                <a class="edit"
                   href="subdomains-edit.php?id={$subdomainss[l].subdomain_id}&amp;code={$subdomainss[l].code}">{icon
                    name='edit'}</a>
                <a class="add"
                   href="subdomains-install.php?id={$subdomainss[l].subdomain_id}&code={$subdomainss[l].code}">{icon
                    name='add' title='Install'}</a>
                <a class="alias"
                   href="subdomains-alias.php?id={$subdomainss[l].subdomain_id}&code={$subdomainss[l].code}"><img
                        src="{'rotate'|icon}" title="Alias: {$subdomainss[l].alias_id}"/></a>
                <a class="analyze"
                   href="subdomains-analyze.php?id={$subdomainss[l].subdomain_id}&code={$subdomainss[l].code}"><img
                        src="{'calculator'|icon}" title="Analyze: {$subdomainss[l].subdomain_name}"/></a> <a
                    class="analyze"
                    href="subdomains-flaghosts.php?id={$subdomainss[l].subdomain_id}&code={$subdomainss[l].code}">{$subdomainss[l].is_live|yn}</a>
            </td>
            <!--{* Management Icons, without being wrapped anymore *}-->
        </tr>
        {sectionelse}
        <tr class="error">
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <!--{* Empty Cells *}-->
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        {/section}
    </table>
    <!--{*
    <div class="block-actions">
        With selected, <input type="hidden" name="action" value="nothing" />
        <select name="actions" id="actions">
            <option value="delete">Delete</option>
            <option value="disable">Disable</option>
            <option value="enable">Enable</option>
            <option value="prune">Prune</option>
            <option value="nothing" selected="selected">Nothing</option>
        </select>
        <input type="submit" name="submit-button" id="submit-button" value="Perform!" />
    </div>
    *}-->
    <div>Live? {'Y'|yn} Y: Live site, {'N'|yn} N: Local site.</div>
</form>
<!-- paginator -->
{if $pagination->has_pages()}
<div class="paginator">
    <span class="paginator-notice">Jump to page:</span> {paginate separator=' ' ulli=false source=$pagination}
</div>
{/if}
<!-- Handlers, Ajax, Validators -->
<!-- Javascript Validators -->
<script type="text/javascript" src="js/ajax.js"></script>
{js src='validators/subdomains/list.js' validator=true}
<!-- End of subdomains List -->