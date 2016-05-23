<?php


$pages = new \subdoamin\pages();
$stats = $pages->statistics();
$smarty->assignByRef('stats', $stats);
