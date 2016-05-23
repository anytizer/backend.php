<?php


$page_id = $variable->get('id', 'integer', 0);
$pages = new \backend\pages();
$pages->reset_sitemap($page_id);

\common\headers::back(\common\url::last_page('pages-list.php'));
