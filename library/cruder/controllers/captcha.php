<?php
/**
 * Captcha Image
 */
$secure = new secure();
$secure->image_headers();
$secure->show_image(4, false);