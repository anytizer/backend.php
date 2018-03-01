<form autocomplete="off" id="alias-form" name="alias-form" method="post" action="?">
    <table>
        <tr>
            <td class="r">sub-domain Considered:</td>
            <td>
                <strong>{$smarty.get.id|table:'query_subdomains':'subdomain_name':'subdomain_id'}</strong>
                ({$smarty.get.id})
            </td>
        </tr>
        <tr>
            <td class="r">Currently behaving as:</td>
            <td>{$alias_id|table:'query_subdomains':'subdomain_name':'subdomain_id'|default:'Not aliased yet'}
                ({$alias_id})
            </td>
        </tr>
        <tr>
            <td class="r">Alias to:</td>
            <td><select name="alias[alias_id]" id="alias[alias_id]">
                    <option value="0">--No active alias (Free/Reset now)</option>
                    {* selected='subdomain_id'|magical *} {html_options options='system:subdomains_available'|dropdown}
                </select></td>
        </tr>
        <tr>
            <td class="r">&nbsp;</td>
            <td><input type="hidden" name="alias[subdomain_id]" value="{$smarty.get.id}"/> <input type="submit"
                                                                                                  name="alias-button"
                                                                                                  value="Alias now"/>
                Or,
                <a href="subdomains-list.php">Cancel</a></td>
        </tr>
    </table>
</form>
<h2>Notes</h2>
<p>The numbers within the braces ( ... ) are the sub-domain IDs</p>
<h2>Warnings</h2>
<ol>
    <li>Do not alias other subdomains to <strong>localhost</strong>.</li>
    <li>Aliased sub-domain must be valid for lifetime.</li>
    <li>All aliased subdomains should be hosted locally.</li>
    <li>Alias names do not follow multiple redirections. So, destined alias should be final sub-domain name.</li>
    <li>Alias name has to be resolved using database query.</li>
    <li>Rather than creating an alias, edit your <strong><a
                href="http://en.wikipedia.org/wiki/Hosts_(file)">hosts</a></strong> file, which is a safe option.
    </li>
</ol>
<script type="text/javascript">
    // choose a default selected sub-domain alias
    document.forms['alias-form'].elements['alias[alias_id]'].value = "{$alias_id}";
</script>
