<?php
namespace common;

/**
 * Anagram
 * @todo Find out the orignal source and author
 */
class anagram
{
	private $counter;
	private $original_word;
	private $original_word_length;
	private $flags_string;

	private $initial_letters;
	private $initial_letters_len;
	private $bInitialLetters;

	private $one_bond;
	private $bOne_bond;

	private $terminal_letters;
	private $terminal_letters_len;
	private $bTerminalLetters;

	private $bonds;
	private $max_bonds;

	private $bSaveFile;
	private $save_file_name;

	private $FileHandle;

	function __construct()
	{
		$this->reset();
	}

	function reset()
	{
		$this->counter = 0;
		$this->bSaveFile = false;
		$this->bInitialLetters = false;
		$this->bTerminalLetters = false;
		$this->bOne_bond = false;

		$this->max_bonds = 0;
		unset($this->bonds);
	}

	function set_save_file($bSF)
	{
		$this->bSaveFile = $bSF;
	}

	function set_save_file_name($name)
	{
		$this->save_file_name = $name;
	}

	function add_bond($letter_position)
	{
		$cnt = count($this->bonds);

		$this->bonds[$cnt] = $letter_position - 1;
		$this->max_bonds = count($this->bonds);

		$this->bOne_bond = true;
	}

	function insert_initials($l)
	{
		$this->initial_letters = $l;
		$this->initial_letters_len = strlen($this->initial_letters);
		$this->bInitialLetters = true;
	}

	function insert_terminals($l)
	{
		$this->terminal_letters = $l;
		$this->terminal_letters_len = strlen($this->terminal_letters);
		$this->bTerminalLetters = true;
	}

	function insert_word($in)
	{
		$this->original_word = $in;

		// creation of flags string

		$this->original_word_length = strlen($in);

		$this->flags_string = "";

		for($i = 0; $i < $this->original_word_length; $i++)
			$this->flags_string .= "N";
	}

	function go()
	{
		if(!isset($this->original_word))
		{
			echo "<br/>No anagram can be performed.<br/>The input word was not initialized !<br/>";

			return;
		}
		else if(strlen($this->original_word) == 0)
		{
			echo "<br/>No anagram can be performed.<br/>The input word is empty !<br/>";

			return;
		}

		$this->counter = 0;
		$this->permute($this->flags_string, "", 0);

		$this->max_bonds = 0;
		unset($this->bonds);
	}


	function display($word)
	{
		if($this->bInitialLetters and $this->bTerminalLetters)
		{
			$initials = substr($word, 0, $this->initial_letters_len);
			$terminals = substr($word, -$this->terminal_letters_len, $this->terminal_letters_len);

			if(strcmp($initials, $this->initial_letters) == 0 and strcmp($terminals, $this->terminal_letters) == 0)
			{
				$this->counter++;

				$outstring = "{$this->counter} <b>{$word}</b><br/>\r\n";

				echo $outstring;
			}
		}
		else if($this->bInitialLetters)
		{
			$initials = substr($word, 0, $this->initial_letters_len);
			if(!strcmp($initials, $this->initial_letters) == 0)
			{
				return;
			}

			$this->counter++;

			$outstring = "{$this->counter} <b>{$word}</b><br/>\r\n";
			echo $outstring;
		}
		else if($this->bTerminalLetters)
		{
			$terminals = substr($word, -$this->terminal_letters_len, $this->terminal_letters_len);
			if(!strcmp($terminals, $this->terminal_letters) == 0)
			{
				return;
			}

			$this->counter++;

			$outstring = "{$this->counter} <b>{$word}</b><br/>\r\n";

			echo $outstring;
		}
		else
		{
			$this->counter++;

			$outstring = "{$this->counter} <b>{$word}</b><br/>\r\n";

			echo $outstring;
		}
	}

	function permute($tmp, $word, $level)
	{
		if(strlen($word) == $this->original_word_length)
		{
			$this->display($word);

			return;
		}

		for($i = 0; $i < $this->original_word_length; $i++)
		{
			if($this->bOne_bond === true and $this->bonds[$level] != -1 and $i != $this->bonds[$level] and $level < $this->max_bonds)
			{
				continue;
			}

			if(strcmp($tmp{$i}, 'N') == 0)
			{
				$word_tmp = $word;
				$word_tmp .= $this->original_word{$i};

				$flags_tmp = $tmp;
				$flags_tmp{$i} = 'Y';

				$this->permute($flags_tmp, $word_tmp, $level + 1);
			}
		}
	}
}
