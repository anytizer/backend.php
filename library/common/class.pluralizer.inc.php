<?php
namespace common;

/**
 * @see https://en.wikipedia.org/wiki/English_plurals
 * @see https://www.learnenglish.de/grammar/pluraltext.html
 * pen pens
 * letter letters
 * goose geese
 * foot feet
 * potato potaoes
 * mouse mice
 * ies
 *   frequency frequencies
 *   copy copies
 *   company companies
 *   cookie cookies
 */
class pluralizer
{
	public function __construct()
	{
	}
	
	private function make_plural(string $word): string
	{
		# What to append to the word to make it plural?
		$plural_marker = "s";
		$data = array();
		switch(true)
		{
			case preg_match("/o$/", $word):
				# Words ending in [ o ]
				$plural_marker = "es";
				break;
			case preg_match("/y$/", $word):
				# Words ending in [ y ]
				$plural_marker = "ies";
				
				# Remove the last letter: [ y ]
				$word = substr($word, 0, strlen($word) - 1);
				break;
			case preg_match("/oo([a-z])?$/", $word, $data):
				$plural_marker = "ee" . $data[1];
				$word = substr($word, 0, strlen($word) - 3);
				break;
			default:
				break;			
		}
		
		#$plural = $word . (($counter != 1) ? $plural_marker : "");
		$plural = $word.$plural_marker;
		return $plural;

		# frequency => frequencies, copy => copies, company => companies
		# cookie => cookies

		# Words having [ oo ] in the second last letters.
		# foot => feet, goose => geese
	}
	
	/**
	 * Singular or Plural based on count
	 */
	public function plural(string $word, int $count): string
	{
		$word = ($count>=2)?$this->make_plural($word):$word;
		return $word;
	}
	
	/**
	 * Alias only, that always pluralizes
	 */
	public function pluralize(string $word): string
	{
		return $this->plural($word, 2);
	}
}