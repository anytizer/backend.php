<?php
namespace backend;
use \Exception;
use \common\tools;
use \common\mysql;

/**
 * Has basics of our framework
 */
class framework
    extends mysql
{
    # Bind the framework to particular context.
    # For future use only
    private $context;

    # sub-domain prefix, used to generate codes
    private $prefix = "";

    /**
     * Load a specific context - Not used so far.
     *
     * framework constructor.
     * @param string $default_context
     * @throws Exception
     */
    public function __construct($default_context = 'config')
    {
        # Load database connections
        parent::__construct();

        # For future only
        $this->context = $default_context;
    }

    /**
     * Generates a unique code for this framework.
     * To be called within a particular sub-domain only, for generating codes
     *
     * @see \common\tools::timestamp()
     *
     * @param int $subdomain_id
     * @return string
     */
    public static function code($subdomain_id = 0)
    {
        $subdomain_id = (int)$subdomain_id;
        $prefix_sql = "
SELECT
	subdomain_prefix
FROM query_subdomains
WHERE
	subdomain_name='{$_SERVER['SERVER_NAME']}'
;";
        $db = new \common\mysql();
        if ($sub-domain = $db->row($prefix_sql)) {
            return $subdomain['subdomain_prefix'] . \common\tools::timestamp();
        } else {
            return tools::timestamp();
        }
    }

    /**
     * If alias ID was set in subdomain, jump to it.
     * In this case, forgets, whatever the earlier sub-domain name was.
     */
    public function reset_server_name_by_alias()
    {
        # When you reset an alias, it may impact in several places:
        # Calling wrong template/controllers
        # Loading different constants
        $alias_changed = false;
        $alias_sql = "
SELECT
	alias_id
FROM query_subdomains
WHERE
	subdomain_name='{$_SERVER['SERVER_NAME']}'
;";
        if ($alias = $this->row($alias_sql)) {
            $alias['alias_id'] = (int)$alias['alias_id']; # Safety conversion

            # No need to convert alias IDs with ZERO (0) values.
            if ($alias['alias_id']) {
                $new_subdomain_sql = "
SELECT
	subdomain_id,
	LOWER(subdomain_name) server_name
FROM query_subdomains
WHERE
	subdomain_id={$alias['alias_id']}
;";
                if ($sub-domain = $this->row($new_subdomain_sql)) {
                    # The main thing here...
                    $_SERVER['SERVER_NAME'] = $subdomain['server_name'];
                    $alias_changed = true;
                }
            }
        }

        return $alias_changed;
    }

    /**
     * Load the user defined constants specific to a subdomain
     * Chooses the currently active subdomain.
     *
     * @param string $context
     */
    public function load_user_defined_constants($context = "")
    {
        # n: Name to define
        # v: Value to define
        # h: Data format handler available within this class
        $load_defines_sql = "
SELECT
	qs.subdomain_id,
	`qd`.`auto_load`,
	UPPER(TRIM(`define_name`)) `n`,
	`define_value` `v`,
	LOWER(`define_handler`) `h`
FROM
	`query_defines` `qd`,
	`query_subdomains` `qs`
WHERE
	`qs`.`subdomain_id`=`qd`.`subdomain_id`
	AND `qs`.`is_active`='Y'
	AND `qd`.`is_active`='Y'
	AND `qd`.`auto_load`='Y'

	# Bind to current sub-domain and framework only
	AND (
		(
			`qs`.`subdomain_name`='{$_SERVER['SERVER_NAME']}'
		)
		OR (
			`qs`.`subdomain_name`='backend'
			AND `qd`.`is_global`='Y'
		)
	)
;";
        $this->query($load_defines_sql);
        while ($this->next_record()) {
            $define = $this->row_data;
            if (!empty($define['n']) && !defined($define['n'])) {
                /**
                 * For safety reasons, the prefix [handler_] is added to the handler function.
                 */
                $handler = 'handler_' . $define['h'];
                if (method_exists($this, $handler)) {
                    # Check handler method within this class
                    $define['v'] = $this->$handler($define['v']);
                } else if (function_exists($handler)) {
                    # Or, check for callable/standard PHP function defined already.
                    $define['v'] = $handler($define['v']);
                } else {
                    # Check for native or without-prefixed functions
                    # Let us NOT use it for safety reasons.
                    # Lose safety examples: (string), file(), is_dir(), ...
                    #if(function_exists($define['h']))
                    {
                        #$handler = $define['h'];
                        #$define['v'] = $handler($define['v']);
                    }
                }
                define($define['n'], $define['v']);
                #echo("<br>Defining: {$define['n']} = {$define['v']}<hr>");
            }
        }
    }

    /**
     * Stores an access log of the browsers.
     * Runs only once, upon successful multiple calls within a single session.
     * Call this function only after defining the session handlers.
     * Otherwise, the data will be recorded on per-page basis.
     */
    public function log_browser_details($subdomain_id = 0)
    {
        $subdomain_id = (int)$subdomain_id;
        $variable = new \common\variable();
        if (!$variable->remember('browser_logged', 'integer', 0)) {
            $header = new \common\headers();
            $crud = new \backend\crud();
            $browser_logged = $crud->add(
                'query_logger',
                array(
                    'subdomain_id' => $subdomain_id,
                    'logged_isp' => $header->isp(),
                    'logged_ip' => $header->ip(true),
                    'added_on' => \common\tools::current_time(), # unix_timestamp(), timestamp(), -- Out of range value for column 'added_on' at row 1
                    'logged_on' => \common\tools::current_time(), # unix_timestamp(), timestamp(), -- Out of range value for column 'logged_on' at row 1
                    'browser_language' => $header->language(),
                    'browser_encoding' => $header->encoding(),
                    'browser_charset' => $header->charset(),
                    'browser_accept' => $header->accept(),
                    'browser_browser' => $header->browser(),
                    'browser_referer' => $header->referer(),
                    'browser_profile' => $header->profile(),
                    'profile_wap' => $header->profile_wap(),
                ),
                array(),
                false,
                false
            );

            $variable->write('session', 'browser_logged', $browser_logged);
        }
    }

    /**
     * Converts server name into sub-domain ID
     * @todo Remove static access to this method.
     */
    public function subdomain_id()
    {
        $subdomain_sql = "
SELECT
	subdomain_id `id`
FROM query_subdomains
WHERE
	subdomain_name='{$_SERVER['SERVER_NAME']}'
	# AND is_active='Y' # Loose searching
;";
        if ($sub-domain = $this->row($subdomain_sql)) {
        } else {
            $sub-domain = array(
                'id' => 0,
            );
        }

        return $subdomain['id'];
    }

    /**
     * Returns a __SUBDOMAIN_BASE__ path to a subdomain
     *
     * Installer Mode ($expected=true)
     * Returns an expected __SUBDOMAIN_BASE__ path of a subdomain. Usage: to install the subdomain.
     * Checks if the sub-domain base exists already.
     * Hides the error messages, unlike subdomain_base()
     * @todo No need to query if sub-domain ID is 0.
     *
     * @param int $subdomain_id
     * @param bool $expected
     * @return string
     */
    public function subdomain_base($subdomain_id = 0, $expected = false)
    {
        $subdomain_id = (int)$subdomain_id;
        $subdomain_sql = "
SELECT
	subdomain_id,
	subdomain_name,
	pointed_to
FROM query_subdomains
WHERE
	subdomain_id={$subdomain_id}
	# AND is_active='Y' # Loose searching
;";
        if (!($sub-domain = $this->row($subdomain_sql))) {
            $sub-domain = array(
                'subdomain_id' => 0,
                'subdomain_name' => $_SERVER['SERVER_NAME'],
                'pointed_to' => '/tmp',
            );
        }
        $possible_bases = explode('|', $subdomain['pointed_to']);

        # Few other Dynamic bases, if located in other than the expected area
        $possible_bases[] = $subdomain['pointed_to'];
        $possible_bases[] = __SERVICES_PATH__ . '/' . $subdomain['subdomain_name'];

        #$possible_bases_existing = array_map('realpath', $possible_bases);
        #$possible_bases_existing = array_filter($possible_bases_existing);

        $possible_bases = array_map(array(new \common\tools(), 'safe_directory_name'), $possible_bases);
        $possible_bases = array_filter($possible_bases);
        #print_r($possible_bases);

        $success = false;
        $__SUBDOMAIN_BASE__ = '/tmp/' . $_SERVER['SERVER_NAME']; # The worst case checker
        foreach ($possible_bases as $pb => $subdomain_base) {
            if (is_dir($subdomain_base)) {
                $success = true;
                $__SUBDOMAIN_BASE__ = $subdomain_base;
                break;
            }
        }

        if (!$success) {
            \common\stopper::message(nl2br("
[ <strong>__SUBDOMAIN_BASE__</strong> ] is NOT located correctly for this subdomain.
This happens when we do not find the pointed location of the server name into its expected area.
It will invite problems in reading template files from unexpected locations.

&bull; Be careful on <strong>aliased server</strong> names.
&bull; The <em>IP address</em>, might have been already assigned to different server name.
&bull; Check if the library/inc/<strong>inc.server.php</strong> has overwritten the server name.

<hr />
Here is the location list of expected area:
" . print_r($possible_bases, true)));
        }

        return $__SUBDOMAIN_BASE__;
    }


    /**********************************************************/
    /**
     * Installs several data handlers to process defined values.
     */
    /**********************************************************/

    /**
     * Extract a zip file into a location.
     * Zip/Unzip needs ZipArchive installed.
     * Caution: It does not run on all servers.
     *
     * @param string $zip_file
     * @param string $unzip_to
     * @return int|mixed
     */
    function unzip($zip_file = 'nothing.zip', $unzip_to = '/tmp')
    {
        $error = 0;
        $errors = array(
            'INVALID_SOURCE_FILE' => 1,
            'INVALID_TARGET_LOCATION' => 2,
            'TARGET_LOCATION_UNWRITABLE' => 3,
            'CANNOT_OPEN_ARCHIVE' => 4,
        );

        if (is_file($zip_file)) {
            if (is_dir($unzip_to)) {
                if (is_writable($unzip_to)) {
                    $zip = new ZipArchive();
                    if ($zip->open($zip_file) === true) {
                        $zip->extractTo($unzip_to);
                        $zip->close();
                    } else {
                        $error = $errors['CANNOT_OPEN_ARCHIVE'];
                    }
                } else {
                    $error = $errors['TARGET_LOCATION_UNWRITABLE'];
                }
            } else {
                $error = $errors['INVALID_TARGET_LOCATION'];
            }
        } else {
            $error = $errors['INVALID_SOURCE_FILE'];
        }

        return $error;
    }

    /**
     * Verifies that the configuration value is an email
     *
     * @param string $value
     * @return string
     */
    private function handler_email($value = "")
    {
        return $value;
    }

    /**
     * Verifies that the configuration value is one of the booleans:
     * true, TRUE, 1
     * false, FALSE, 0
     *
     * @param string $value
     * @return string
     */
    private function handler_boolean($value = "")
    {
        return $value;
    }

    /**
     * Verifies that the configuration value is in YYYY-MM-DD format
     *
     * @param string $value
     * @return string
     */
    private function handler_date($value = "")
    {
        return $value;
    }

    /**
     * Verifies that the configuration value is in HH:MM:DD time format
     *
     * @param string $value
     * @return string
     */
    private function handler_time($value = "")
    {
        return $value;
    }

    /**
     * Extracts all digits from a value.
     * It does not accept FLOAT.ING numbers.
     *
     * @param string $value
     * @return null|string|string[]
     */
    private function handler_numeric($value = "")
    {
        $value = preg_replace('/[^\d]+/', "", $value);

        return $value;
    }

    /**
     * String data sanitizer
     *
     * @param string $value
     * @return string
     */
    private function handler_string($value = "")
    {
        return $value;
    }

    /**
     * URL data validator
     *
     * @param string $value
     * @return string
     */
    private function handler_url($value = "")
    {
        return $value;
    }
}

