<?php

/**
 * MyPagina ver. 1.03
 * Handle MySQL record sets and get page navigation links
 * Modified for use with Yet Another Link Directory
 */
class MyPagina
{

    public $sql;
    public $result;
    public $outstanding_rows = false;

    public $get_var;
    public $rows_on_page;

    public $max_rows;

    public $catpath = null;
    public $catid = null;
    public $catname = null;

    public $qs_var = 'page'; // query string variable
    public $str_fwd = '&raquo'; // right arrow text
    public $str_bwd = '&laquo'; // left arrow text
    public $num_links = 5; // links inside navigation

    // constructor
    function __construct($rows_per_page, $rows = 0)
    {
        $this->max_rows = $rows;
        $this->get_var = $this->qs_var;
        $this->rows_on_page = $rows_per_page;
    }

    // sets the current page number

    function get_page_result()
    {
        $start = $this->set_page() * $this->rows_on_page;
        $page_sql = sprintf('%s LIMIT %s, %s', $this->sql, $start, $this->rows_on_page);
        $this->result = mysql_query($page_sql);

        return $this->result;
    }

    // gets the total number of records

    function set_page()
    {
        $page = (isset($_REQUEST[$this->get_var]) && $_REQUEST[$this->get_var] != "") ? $_REQUEST[$this->get_var] : 0;

        return $page;
    }

    // get the totale number of result pages

    function get_page_num_rows()
    {
        $num_rows = mysql_num_rows($this->result);

        return $num_rows;
    }

    // returns the records for the current page

    function free_page_result()
    {
        mysql_free_result($this->result);
    }

    // get the number of rows on the current page

    function rebuild_qs($curr_var)
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            $parts = explode('&', $_SERVER['QUERY_STRING']);
            $newParts = array();
            foreach ($parts as $val) {
                if (stristr($val, $curr_var) == false) {
                    array_push($newParts, $val);
                }
            }
            if (count($newParts) != 0) {
                $qs = '&' . implode('&', $newParts);
            } else {
                return false;
            }

            return $qs; // this is your new created query string
        } else {
            return false;
        }
    }

    // free the database result

    function page_info($str = 'Result: %d - %d of %d')
    {
        $first_rec_no = ($this->set_page() * $this->rows_on_page) + 1;
        $last_rec_no = $first_rec_no + $this->rows_on_page - 1;
        $last_rec_no = ($last_rec_no > $this->get_total_rows()) ? $this->get_total_rows() : $last_rec_no;
        $info = sprintf($str, $first_rec_no, $last_rec_no, $this->get_total_rows());

        return $info;
    }

    // function to handle other querystring than the page variable

    function get_total_rows()
    {
        $tmp_result = mysql_query($this->sql);
        $all_rows = mysql_num_rows($tmp_result);
        if (!empty($this->max_rows) && $all_rows > $this->max_rows) {
            $all_rows = $this->max_rows;
            $this->outstanding_rows = true;
        }
        mysql_free_result($tmp_result);

        return $all_rows;
    }

    // this method will return the navigation links for the conplete recordset

    function back_forward_link($images = false)
    {
        $simple_links = $this->navigation(' ', "", true, $images);

        return $simple_links;
    }

    // function to create the back/forward elements; $what = forward or backward
    // type = text or img

    function navigation($separator = ' | ', $css_current = "", $back_forward = false, $use_images = false)
    {
        $max_links = $this->num_links;
        $curr_pages = $this->set_page();
        $all_pages = $this->get_num_pages() - 1;
        $var = $this->get_var;
        $navi_string = "";
        if (!$back_forward) {
            $max_links = ($max_links < 2) ? 2 : $max_links;
        }
        if ($curr_pages <= $all_pages && $curr_pages >= 0) {
            if ($curr_pages > ceil($max_links / 2)) {
                $start = ($curr_pages - ceil($max_links / 2) > 0) ? $curr_pages - ceil($max_links / 2) : 1;
                $end = $curr_pages + ceil($max_links / 2);
                if ($end >= $all_pages) {
                    $end = $all_pages + 1;
                    $start = ($all_pages - ($max_links - 1) > 0) ? $all_pages - ($max_links - 1) : 1;
                }
            } else {
                $start = 0;
                $end = ($all_pages >= $max_links) ? $max_links : $all_pages + 1;
            }
            if ($all_pages >= 1) {
                $forward = $curr_pages + 1;
                $backward = $curr_pages - 1;
                // the text two labels are new sinds ver 1.02
                $lbl_forward = $this->build_back_or_forward('forward', $use_images);
                $lbl_backward = $this->build_back_or_forward('backward', $use_images);

                $bwd_url = rewriteUrl($this->catid, $this->catname, $this->catpath, $backward);

                $navi_string = ($curr_pages > 0) ? '<a href="' . $bwd_url . '">' . $lbl_backward . '</a>&nbsp;' : $lbl_backward . '&nbsp;';
                if (!$back_forward) {
                    for ($a = $start + 1; $a <= $end; $a++) {
                        $theNext = $a - 1; // because a array start with 0
                        if ($theNext != $curr_pages) {
                            $navi_url = rewriteUrl($this->catid, $this->catname, $this->catpath, $theNext);

                            $navi_string .= '<a href="' . $navi_url . '">';
                            $navi_string .= $a . '</a>';
                            $navi_string .= ($theNext < ($end - 1)) ? $separator : "";
                        } else {
                            $navi_string .= ($css_current != "") ? '<span class="' . $css_current . '">' . $a . '</span>' : $a;
                            $navi_string .= ($theNext < ($end - 1)) ? $separator : "";
                        }
                    }
                }

                $fwd_url = rewriteUrl($this->catid, $this->catname, $this->catpath, $forward);

                $navi_string .= ($curr_pages < $all_pages) ? '&nbsp;<a href="' . $fwd_url . '">' . $lbl_forward . '</a>' : '&nbsp;' . $lbl_forward;
            }
        }

        return $navi_string;
    }

    // this info will tell the visitor which number of records are shown on the current page

    function get_num_pages()
    {
        $number_pages = ceil($this->get_total_rows() / $this->rows_on_page);

        return $number_pages;
    }

    // simple method to show only the page back and forward link.

    function build_back_or_forward($what, $img = false)
    {
        $label['text']['forward'] = $this->str_fwd;
        $label['text']['backward'] = $this->str_bwd;
        $label = $label['text'][$what];

        return $label;
    }
}

