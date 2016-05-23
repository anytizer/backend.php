<?php
# Updates the number of pages counter in each subdomains.
$subdomains = new \subdomain\subdomains();
$subdomains->update_pages_counter();

$sql = "
SELECT
	`subdomain_id` `id`,
	`subdomain_name` `sn`,
	`subdomain_comments` `sc`,
	`subdomain_description` `sd`,
	`pages_counter` `pages`
FROM `query_subdomains`
WHERE
	`is_active`='Y'
	AND `is_approved`='Y'
	AND `is_hidden`='N'
	AND alias_id=0
GROUP BY
	`subdomain_name`
ORDER BY
	sn
;";
$db->query($sql);
$subdomains = $db->to_array();
$smarty->assign('subdomains', $subdomains);
