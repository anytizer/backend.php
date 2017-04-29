<?php
/**
 * Deletes a particular page. It does not validate. So, just be careful.
 */

$pages->delete($page_id = $variable->get('pi', 'integer', 0), $code = $variable->get('code', 'string', ""));
print_r($pages);
print_r($_GET);

\common\headers::back('pages-list.php#bottom');
