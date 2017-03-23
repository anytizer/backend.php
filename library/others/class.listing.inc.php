<?php
namespace others;

/**
 * A standard class to list out the wordpress and phpbb items for making urls
 * @todo Replace MySQL with MySQLi
 */
class listing
{
    public $connections; # List of user connection details
    public $connection_pool; # List of connection pools
    public $total_list = 15;

    # When there is no data, use this unit
    public $blank = array(
        'links' => array(),
        'total' => 0,
    );

    public function __construct()
    {
        $this->connections = array();
        # host, username, password, database, <option: table name, prefix, ...>
        $this->connections['listing0'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing1'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing2'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing3'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing4'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing5'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing6'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing7'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing8'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
        $this->connections['listing9'] = array('dbserver', 'dbuser', 'dbpassword', "", "");
    }

    /**
     * Collects recent posts from a WordPress database
     */
    function list_wp($index = "")
    {
        if ($blank = $this->blank()) {
            return $this->blank;
        }

        $connection = &$this->connection_pool[$this->connect_database($index)];

        switch ($index) {
            case 'fashion':
            default: # Anything else is assumed to be WordPress
                $sql = "
SELECT SQL_NO_CACHE SQL_CALC_FOUND_ROWS
	post_title tt,
	guid u
FROM `{$this->connections[$index][4]}`
WHERE
	post_type = 'post'
	AND post_status = 'publish'
ORDER BY id DESC
LIMIT 0 , {$this->total_list};";
                break;
        }
        #echo("\n\n{$sql}\n\n");

        # A Dummy links holder
        $links = array();
        $links['links'] = array();
        $links['total'] = 0;
        if ($rs_lists = mysql_query($sql, $connection)) {
            $rs_total = mysql_query('SELECT FOUND_ROWS() t;', $connection);
            $total = mysql_fetch_assoc($rs_total);
            $links['total'] = $total['t'];

            while ($title = mysql_fetch_assoc($rs_lists)) {
                $title['tt'] = $this->shorten_words($title['tt']);
                $links['links'][] = "<li><a href='{$title['u']}'>{$title['tt']}</a></li>";
            }
        }

        return $links;
    }

    /**
     * On a development servers, do not show the contents.
     * Prevent the connections on the servers.
     */
    function blank()
    {
        if (in_array($_SERVER['SERVER_NAME'], array('localhost', 'hasee'))) {
            return true;
        }

        return false;
    }

    /**
     * Creates a pool of database connections.
     * Returns an index name to the connection pool.
     */
    function connect_database($index = "")
    {
        if (empty($this->connections[$index])) {
            \common\stopper::message('empty index');

            return false;
        }

        $connection_md5 = md5("{$this->connections[$index][2]}{$this->connections[$index][1]}{$this->connections[$index][0]}");
        #echo("\n\nConnecting pool: {$connection_md5} - {$index} - <{$this->connections[$index][2]}{$this->connections[$index][1]}{$this->connections[$index][0]}> - {$this->connections[$index][2]}, {$this->connections[$index][1]}, {$this->connections[$index][0]})");
        #\common\stopper::debug($this->connections[$index], false);
        if (empty($this->connection_pool[$connection_md5])) # Force database connection once
        {
            $this->connection_pool[$connection_md5] = mysql_connect(
                $this->connections[$index][0],
                $this->connections[$index][1],
                $this->connections[$index][2]
            ) or \common\stopper::message('Error connecting: ' . mysql_error());

            mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';", $this->connection_pool[$connection_md5]); # or \common\stopper::message('Error setting charset: '.mysql_error());
        }
        mysql_select_db($this->connections[$index][3], $this->connection_pool[$connection_md5]); # Each time, a different database might be selcted

        #$connection = $this->connection_pool[$connection_md5]; # Saves a connection pool
        #$connection); # or \common\stopper::message('Error selecting db: '.mysql_error());

        return $connection_md5;
    }

    /**
     * Briefly reduce the number of words in a string.
     */
    function shorten_words($string = "")
    {
        $total_words_allowed = 8;
        $append = "";
        $words = explode(' ', $string);
        #echo(" <!-- "); \common\stopper::debug($words, false); echo(" --> ");
        $words_new = array();
        if (count($words) <= $total_words_allowed) {
            $words_new = $words;
        } else {
            # Truncate the last ones.
            for ($i = 0; $i < $total_words_allowed; ++$i) {
                $words_new[] = $words[$i];
            }
            $append = ' ...';
        }

        return implode(' ', $words_new) . $append;
    }

    function list_phpbb($index = "")
    {
        if ($blank = $this->blank()) {
            return $this->blank;
        }

        $connection = &$this->connection_pool[$this->connect_database($index)];

        switch ($index) {
            case 'board':
            default:
                # Something is assumed to be PHPBB
                $sql = "
SELECT SQL_NO_CACHE SQL_CALC_FOUND_ROWS
	t.topic_id ti,
	t.topic_title tt,
	f.forum_name fn
FROM phpbb_topics t
INNER JOIN phpbb_forums f ON f.forum_id = t.forum_id
WHERE
	topic_approved=TRUE
ORDER BY
	topic_last_post_id DESC
LIMIT 0, {$this->total_list};";
        }
        #echo("\n\n{$sql}\n\n");

        # A Dummy links holder
        $links = array();
        $links['links'] = array();
        $links['total'] = 0;
        if ($rs_phpbb = mysql_query($sql, $connection)) {
            $rs_total = mysql_query('SELECT FOUND_ROWS() t;', $connection);
            $total = mysql_fetch_assoc($rs_total);
            $links['total'] = $total['t'];

            while ($title = mysql_fetch_assoc($rs_phpbb)) {
                $title['tt'] = $this->shorten_words($title['tt']);
                $links['links'][] = "<li><a href='viewtopic.php?t={$title['ti']}'>{$title['tt']}</a> - in: {$title['fn']}</li>";
            }
        }

        return $links;
    }

    /**
     * Pull links from the NLD
     */
    function list_nld($index = "")
    {
        if ($blank = $this->blank()) {
            return $this->blank;
        }

        $connection = &$this->connection_pool[$this->connect_database($index)];

        switch ($index) {
            case 'nld':
            default:
                # Something is assumed to be PHPBB
                $sql = "
# List of links added recently
SELECT SQL_NO_CACHE SQL_CALC_FOUND_ROWS
	u.status tt,
	u.tp_url url,
	c.cat_name cat
FROM links_urls u
INNER JOIN links_categories c ON
	c.cat_id = u.cat_id
	AND c.is_active='Y'
	AND u.is_active='Y'
ORDER BY
	url_id DESC
LIMIT 0, {$this->total_list};";
        }
        #echo("\n\n{$sql}\n\n");

        # A Dummy links holder
        $links = array();
        $links['links'] = array();
        $links['total'] = 0;
        if ($rs_phpbb = mysql_query($sql, $connection)) {
            $rs_total = mysql_query('SELECT FOUND_ROWS() t;', $connection);
            $total = mysql_fetch_assoc($rs_total);
            $links['total'] = $total['t'];

            while ($title = mysql_fetch_assoc($rs_phpbb)) {
                $title['tt'] = $this->shorten_words($title['tt']);
                $links['links'][] = "<li><a href='{$title['url']}'>{$title['tt']}</a> - in: {$title['cat']}</li>";
            }
        }

        return $links;
    }
}
