<?php
#namespace plugins;

/**
 * IEPNG Fix - Smarty plugin
 * File:     compiler.iepngfix.php
 * Type:     compiler
 * Name:     iepngfix
 * Purpose:  Scripts for IE PNG Fix.
 */
function smarty_compiler_iepngfix($tag_arg, $smarty)
{
	$text = '
<!--[if IE]>
<style type="text/css">
	img { behavior: url("js/iepngfix/iepngfix.htc") }
</style>
<script type="text/javascript" src="js/iepngfix/iepngfix_tilebg.js"></script>
<![endif]-->
';

	return $text;
}
