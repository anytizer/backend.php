<p>
    <a href="{\common\url::last_page('subdomains-list.php')}">Go back</a> and list subdomains or visit the current
    sub-domain website:
    <a href="{$smarty.get.id|subdomain_url}">{$smarty.get.id|table:'query_subdomains':'subdomain_name':'subdomain_id'}</a>.
</p>
<h2>Latest status</h2>
<p>is_down = {$details.is_down|yn}</p>
