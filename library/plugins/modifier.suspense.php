<?php
#namespace plugins;

/**
 * Help to generate a random letter at once
 */
function smarty_modifier_suspense_helper_suspense_character($letter = '')
{
	$suspense_character = chr(mt_rand(ord('a'), ord('z')));

	return $suspense_character;
}

/**
 * Suspense a word.
 * Usage example: in hiding details of a username.
 * Inspired by: Google's .SVN Server.
 */
function smarty_modifier_suspense($word = '')
{
	# suspense using this set of character(s)
	#$suspense_character = '_';
	$suspense_character = chr(mt_rand(ord('a'), ord('z')));

	$letters = str_split($word, 1);

	if(count($letters) <= 2)
	{
		# Hide all characters when the total length is too small.
		foreach($letters as $l => $letter)
		{
			#$letters[$l] = $suspense_character;
			$letters[$l] = smarty_modifier_suspense_helper_suspense_character($letter);
		}
	}
	else
	{
		foreach($letters as $l => $letter)
		{
			if($l % 3 == mt_rand(0, 2))
			{
				# Randomly hide some letters
				#$letters[$l] = $suspense_character;
				$letters[$l] = smarty_modifier_suspense_helper_suspense_character($letter);
			}
		}

		# Make sure to suspense, even if mt_rand() genrated all zeros.
		#$letters[1] = $suspense_character;
		$letters[1] = smarty_modifier_suspense_helper_suspense_character();
	}
	$letters[] = '...';

	return implode('', $letters);
}
