<?php
namespace common;

/**
 * Provides links to paginate.
 * Notice: When you use ULLI=TRUE parameter, you must bind the paginated links within UL tags yourself.
 */
class pagination
{
    private $total; # Total number of entries to paginate
    private $per_page_limit; # Per page listing limits
    private $pages; # Total number of pages: total/per_page_limit
    private $current_page; # Current page being traversed to
    private $parameter_name; # GET paramenter name

    private $marginal_separator = ""; # ... wrapper that separates numers and first/last, next/previous buttons

    public function __construct($parameter_name = 'pg', $per_page_limit = 10)
    {
        # Default beginning
        $variable = new \common\variable();
        $this->parameter_name = $parameter_name;
        $this->current_page = $variable->get($parameter_name, 'integer', 1); # DO NOT CHNAGE IT
        $this->per_page_limit = (int)$per_page_limit;
    }

    /**
     * Sets the total number of records and calculates the total number of pages possible.
     */
    public function set_total($total = 0)
    {
        $this->total = (int)$total;
        $this->pages = ceil($this->total / $this->per_page_limit);
    }

    /**
     * Determine the number of pages possible
     */
    public function show_pages($link_file = 'page.php', $ulli = true, $separator = ' ')
    {
        # Do not allow ( ? ) - Important
        $link_file = ($link_file == '?') ? "" : $link_file;

        $wrap_begin = "";
        $wrap_end = "";
        if ($ulli === true) {
            $wrap_begin = '<li>';
            $wrap_end = '</li>';
        }

        $this->marginal_separator = "{$wrap_begin}<span class=\"page-dotted\">...</span>{$wrap_end}";

        $pagination_links = array();
        for ($i = 1; $i <= $this->pages; ++$i) {
            $class = ($this->current_page == $i) ? ' class="current"' : "";
            $pagination_links[] = "{$wrap_begin}<span class=\"page-number\"><a href=\"{$link_file}?{$this->parameter_name}={$i}\" id=\"PG{$i}\"{$class}>{$i}</a></span>{$wrap_end}";
        }
        #\common\stopper::debug($pagination_links, false);
        #return $pagination_links;
        return implode($separator, $pagination_links);
    }

    public function show_pages_slider($link_file = 'page.php', $ulli = true, $separator = ' ')
    {
        $slider = 10; # Even number only
        $left = floor($this->current_page - $slider / 2);
        $left = ($left >= 1) ? $left : 1;

        $right = ceil($this->current_page + $slider / 2);
        if ($right >= $this->pages) {
            $right = $this->pages;
        }
        if ($right <= $slider) {
            $right = $slider;
        }

        # Do not allow ( ? ) - Important
        $link_file = ($link_file == '?') ? "" : $link_file;

        $wrap_begin = "";
        $wrap_end = "";
        if ($ulli === true) {
            $wrap_begin = '<li>';
            $wrap_end = '</li>';
        }

        $this->marginal_separator = "{$wrap_begin}<span class=\"page-dotted\">...</span>{$wrap_end}";

        $pagination_links = array();

        # first, previous, ...slider..., next, last

        $pagination_links[] = "{$wrap_begin}<span class=\"page-first\"><a href=\"{$link_file}?{$this->parameter_name}=1\" id=\"PG-FIRST\">First</a></span>{$wrap_end}";

        $prev = $this->current_page - 1;
        $prev = ($prev <= 1) ? 1 : $prev;
        $pagination_links[] = " {$this->marginal_separator} {$wrap_begin}<span class=\"page-prev\"><a href=\"{$link_file}?{$this->parameter_name}={$prev}\" id=\"PG-PREV\">Prev</a></span>{$wrap_end} {$this->marginal_separator} ";

        for ($i = $left; $i <= $right; ++$i) {
            $current_class_span = ($this->current_page == $i) ? ' current' : ""; # [space] applied in front of the value
            $class = ($this->current_page == $i) ? ' class="current"' : "";

            #if($this->pages <= $right)
            $link = "{$wrap_begin}<span class=\"page-disabled\">{$i}</span>{$wrap_end}";
            if ($i <= $this->pages) {
                $link = "{$wrap_begin}<span class=\"page-number{$current_class_span}\"><a href=\"{$link_file}?{$this->parameter_name}={$i}\" id=\"PG{$i}\"{$class}>{$i}</a></span>{$wrap_end}";
            }
            $pagination_links[] = $link;
        }

        $next = $this->current_page + 1;
        $next = ($next > $this->pages) ? $this->pages : $next;
        $pagination_links[] = " {$this->marginal_separator} {$wrap_begin}<span class=\"page-next\"><a href=\"{$link_file}?{$this->parameter_name}={$next}\" id=\"PG-NEXT\">Next</a></span>{$wrap_end}";
        $pagination_links[] = " {$this->marginal_separator} {$wrap_begin}<span class=\"page-last\"><a href=\"{$link_file}?{$this->parameter_name}={$this->pages}\" id=\"PG-LAST\">Last</a></span>{$wrap_end}";

        #\common\stopper::debug($pagination_links, false);
        #return $pagination_links;
        return implode($separator, $pagination_links);
    }

    /**
     * For SQL Assistance only
     */
    public function page_limits()
    {
        # First LIMIT should start from ZERO (0)
        # 		$this->limit_from_begin = 0;
        #private $limit_from_begin; # SQL LIMIT begins this number
        #$limit_from
        #  + 1
        $limit_from_begin = ($this->current_page - 1) * $this->per_page_limit; # Show from this much records, DO NOT CHANGE
        #return "({$limit_from_begin}, {$this->per_page_limit})";
        return "{$limit_from_begin}, {$this->per_page_limit}";
        #return "From: {$limit_from_begin} - To: {$this->per_page_limit}";
    }

    /**
     * Begin from this entry to list out
     */
    public function beginning_entry()
    {
        $limit_from_begin = ($this->current_page - 1) * $this->per_page_limit; # Show from this much records, DO NOT CHANGE
        return $limit_from_begin;
    }

    /**
     * Total number of records
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * Per page counter
     */
    public function per_page()
    {
        return $this->per_page_limit;
    }

    /**
     * Current page
     */
    public function current_page()
    {
        return $this->current_page;
    }

    /**
     * Determines the need of pagination, to assist template - whether to show pagination.
     * If false, no need to show the paginator.
     */
    public function has_pages()
    {
        $has_pages = $this->total > $this->per_page_limit;
        return $has_pages;
    }
}
