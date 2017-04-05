<?php
#namespace plugins;

/**
 * Makes a word plural, with easy guessing only.
 * http://www.factmonster.com/ipka/A0886509.html
 * @url http://www.smarty.net/forums/viewtopic.php?t=18399
 * @example {"page"|plural:2}
 */

function smarty_modifier_plural($word = "", $counter = 0)
{
	$pluralizer = new \common\pluralizer();
	$word = $pluralizer->pluralize($word, $counter);
	
	return $word;
}
