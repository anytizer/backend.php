<?php
#namespace plugins;

/**
 * Prints out A - Z with a link
 * @url http://www.smarty.net/forums/viewtopic.php?p=60100
 *
 * @author Bimal Poudel <smarty (at) bimal (dot) org (dot) np>
 */

function smarty_function_a2z($params = array(), &$smarty)
{
	$params['url'] = !empty($params['url']) ? $params['url'] : 'letter.php';
	$params['name'] = !empty($params['name']) ? $params['name'] : 'L'; # GET index
	$params['active'] = !empty($params['active']) ? $params['active'] : 'A';

	$links = array();
	for($letter = ord('A'); $letter <= ord('Z'); ++$letter)
	{
		$alphabet = chr($letter);
		$active = ($alphabet == $params['active']) ? ' class="active"' : '';
		$links[] = "<li{$active}><span><a href='{$params['url']}?{$params['name']}={$alphabet}'>{$alphabet}</a></span></li>";
	}

	return implode('', $links);
}

/*# Usages:

<ul class="alphabets"> 
  {a2z url='begin.php' name='letter' active='C'} 
</ul>

Possible CSS:

ul.alphabets 
{ 
} 

ul.alphabets li 
{ 
   list-style:none; 
   float:left; 
   margin-right:5px; 
   padding:3px 5px 3px 5px; 
   border:1px solid #FFFFFF; 
   text-align:center; 
} 

ul.alphabets li.active, ul.alphabets li:hover 
{ 
   background-color:#990000; 
   border:1px solid #FFFF00; 
} 
ul.alphabets li a 
{ 
   text-decoration:none; 
} 
ul.alphabets li.active a, ul.alphabets li:hover a 
{ 
   color:#CCCCCC; 
}

*/
