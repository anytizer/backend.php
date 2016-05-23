<?php
# Ajax output, if a page exists.

# Samples of URL Queried here
# ajax-page-valid.php?subdomain_id=43&page_name=login.php&rand=0.9735699623866411

$subdomain_id = $variable->get('subdomain_id', 'integer', 0);
$page_name = $variable->get('page_name', 'string', '');
if($pages->if_page_exists($subdomain_id, $page_name))
{
	echo('<img src="images/selected-icons/tick.png" /> Page name valid. You can continue.');
}
else
{
	echo('<img src="images/selected-icons/cross.png" /> Choose a <strong>different</strong> name. It exists already, or name is invalid.');
}

/**
 * # A dump of _GET parameters
 * Array
 * (
 * [page] => ajax-page-valid.php
 * [subdomain_id] => 43
 * [page_name] => login.php
 * [rand] => 0.9735699623866411
 * )
 */
