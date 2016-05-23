<?php
require_once('../inc.bootstrap.php');
require_once($backend['paths']['__LIBRARY_PATH__'].'/inc/inc.config.php');

\common\headers::plain();
#\common\headers::png();

# 16px x 16px icons (width x height)
# 20 columns x 20 rows of grid
$iconizer = new iconizer(16, 16, 20, 20);
$html_filename = $iconizer->iconize(__APP_PATH__.'/images/selected-icons', 'my-icons.css');

header('Location: selected-icons/'.$html_filename);
