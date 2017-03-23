<?php
namespace common;

/**
 * Helps to extract text information using regular expressions
 *
 * @package Common
 */
class inside
{
    private $delimiter = '/';

    public function __construct()
    {
    }

    public function one($text = "", $left_boundary = "", $right_boundary = "")
    {
        $data = array();
        $pattern = $this->pattern($left_boundary, $right_boundary);
        #$pattern = '@'.str_replace('@', '\\@', preg_quote($left_boundary)).'(.*?)'.str_replace('@', '\\@', preg_quote($right_boundary)).'@is';
        preg_match_all($pattern, $text, $data);

        #print_r($data);
        return isset($data[1][0]) ? $data[1][0] : "";
    }

    private function pattern($left_boundary = "", $right_boundary = "")
    {
        $left_boundary = str_replace('.*?', '___', $left_boundary);
        $right_boundary = str_replace('.*?', '___', $right_boundary);

        $pattern = '@' . str_replace('@', '\\@', preg_quote($left_boundary)) . '(.*?)' . str_replace('@', '\\@', preg_quote($right_boundary)) . '@is';

        $pattern = str_replace('___', '.*?', $pattern);

        #echo('pat: '.$pattern);
        return $pattern;
    }

    public function all_inside($text = "", $left_outer_boundary = "", $right_outer_boundary = "", $left_inner_boundary = "", $right_inner_boundary = "")
    {
        $head = $this->block($text, $left_outer_boundary, $right_outer_boundary);
        #die('...'.$head);

        $data = array();
        $pattern = $this->pattern($left_inner_boundary, $right_inner_boundary);
        #'@'.str_replace('@', '\\@', preg_quote($left_inner_boundary)).'(.*?)'.str_replace('@', '\\@', preg_quote($right_inner_boundary)).'@is';
        #die('...'.$pattern);
        preg_match_all($pattern, $head, $data, PREG_PATTERN_ORDER);
        #print_r($data);
        #return array_values($data[1]);
        return isset($data[1]) ? $data[1] : array();
    }

    public function block($text = "", $left_boundary = "", $right_boundary = "")
    {
        $data = array();
        $pattern = $this->pattern($left_boundary, $right_boundary);
        #$pattern = '@'.str_replace('@', '\\@', preg_quote($left_boundary)).'(.*?)'.str_replace('@', '\\@', preg_quote($right_boundary)).'@is';
        preg_match_all($pattern, $text, $data);
        #print_r($data);
        #die($pattern);
        return isset($data[1][0]) ? $data[1][0] : "";
    }

    public function grab($text = "", $full_pattern = '/^(.*?)$/is')
    {
        $data = array();
        preg_match($full_pattern, $text, $data);

        #print_r($data);
        return isset($data[0]) ? $data[0] : "";
        #die('------------');
    }


    public function grab_all($text = "", $full_pattern = '/^(.*?)$/is')
    {
        #$full_pattern = str_replace('(.*?)', 'dotstartwhat', $full_pattern);
        #$full_pattern = preg
        $data = array();
        preg_match_all($full_pattern, $text, $data);

        #print_r($data);
        return isset($data[1]) ? $data[1] : array();
    }
}
