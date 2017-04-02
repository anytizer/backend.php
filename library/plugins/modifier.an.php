<?php
#namespace plugins;

/**
 * Puts 'a' or 'an' infront of a word. For general use only.
 *
 * @example {'meeting'|an} => a meeting
 * @example {'agenda'|an}  => an agenda
 */
function smarty_modifier_an($word = "")
{
    $word = "{$word}"; # Make it a string, if not.

    # If the word terminates in the letter 's', it is probably a plural word.
    # Do nothing.
    if (preg_match('/s$/i', $word)) {
        return $word;
    }

    $article = 'a';

    $word_clean = preg_replace('/[^a-z]+/i', "", $word);

    if (strlen($word_clean) > 1) {
        # This is a multi letter word
        switch (strtoupper($word[0])) {
            case 'A':
            case 'E':
            case 'I':
            case 'O':
            case 'U':
                $article = 'an';
                break;
            default:
        }
    } else if (strlen($word_clean) == 1) {
        # This is a single letter word, process for letters
        switch (strtoupper($word[0])) {
            case 'A':
            case 'E':
            case 'F':
            case 'H':
            case 'I':
            case 'L':
            case 'M':
            case 'N':
            case 'O':
            case 'R':
            case 'S':
            case 'U':
            case 'X':
                $article = 'an';
                break;
            default:
        }
    } else {
        # This word is empty
        # It is probably an error
        return $word;
    }

    return "{$article} {$word}";
}
