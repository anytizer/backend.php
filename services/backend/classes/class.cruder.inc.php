<?php
namespace subdomain;
use \common\mysql;

/**
 * Helps to create an automatic full CRUD class for each entity under consideration.
 * Tightly integrated with our framework and database logics.
 * It helps saving time by self generating a lot of php codes to perform various CRUD actions.
 *
 * @todo Replace using .sqlite database
 */
class cruder
    extends mysql
{
    private $entity_name = null;

    # Other pre-defined, globally known unacceptable names
    # When they are the flag columns or do not fall under \Exceptions, we list them here
    private $unacceptable_names = array(
        'id',
        'sink_weight',
        'auto_load',
        'rgt', # Managing hierarchical data
        'lft' # Managing hierarchical data
    );

    # Invalid names to show in auto generated templates can be:
    private $invalid_names_regex = array(
        # Unknown/rejected/suspended/unconsidered/temporary fields

        # Fields begin with an underscore for the purpose of backup/references only
        '/^_/is', # _* = flags         : _property_rating
        '/_$/is', # _* = flags         : property_rating_

        # By prefix
        '/^allows?_/is', # allow_ = flags     : allow_edit, allows_submission...
        '/^allowed_/is', # allowed_ = flags   : allowed_images, ...
        '/^auth_/is', # auth_  = authorization flags : auth_upload, auth_vote, ...
        '/^can_/is', # can_ = flags       : can_edit, ...
        #'/^code_/is',   # code_ = secret     : code_word, ...
        '/^count_/is', # count_ = flags     : count_services
        '/^counter_/is', # counter_ = flags   : counter_modifications, ...
        '/^do_/is', # do_ = flags        : do_email, ...
        '/^edit_/is', # edit_ = permission flags : edit_users, ...
        '/^flag_/is', # flag_ = flags      : flag_admin, flag_counter, ...
        '/^has_/is', # has_  = flags      : has_paid, has_accounts, ...
        '/^hits?_/is', # has_  = flags      : has_paid, has_accounts, ...
        '/^in_/is', # in_ = flags        : in_sitemap, ...
        '/^ip_/is', # ip_ = Address      : ip_address, ip_server1, ...
        '/^is_/is', # is_ = flags        : is_active, is_admin, ...
        '/^needs_/is', # needs_ = flags     : needs_login, ...
        '/^show_/is', # show_ = flags      : show_comments, show_samples, ...
        '/^stats?_/is', # stats_ = flags     : stats_size, stats_css, ...
        #'/^status_/is', # needs_ = flags     : status_counter, ... # Sometimes we need to write on this flag
        '/^view_/is', # view_ = permission flags      : view_users, ...

        # Instant messaging
        '/^im_/is', # im_ = flags        : im_facebook, im_msn, ...

        # By suffix
        #'/_code$/is',   # _code = secret     : pin_code, ...
        '/_allowed$/is', # _allowed = images_allowed
        '/_count$/is', # _count : products_count
        '/_counter$/is', # _counter = access counters
        '/_flag/is', # _flag = flags      : admin_flag
        '/_hits?$/is', # _hits = Counters : cat_hits, ...
        '/_id$/is', # _id = parents      : entity_id, row_id, ...
        '/_ip$/is', # _ip = IP Addresses : user_ip, ...
        #'/_number$/is',  # _number = flags : rank_number: Avoid phone number
        '/_order$/is', # _order = sorting flags : cat_order, ...
        #'/_status$/is',  # _status = class_status, like published/unpublished or other status

        # System level flags (Dates and related)
        #'/_date$/is', # _from = date/time flags : event_date, ... # Use date picker rather
        #'/_from$/is', # _from = date/time flags : event_from, ...
        #'/_upto$/is', # _upto = date/time flags : event_upto, ...
        '/_on$/is', # _on = dates, times : modified_on, added_on, ... particularly INT types
        '/_since$/is', # _since = dates, times : begun_since, ...
        '/_by$/is', # _by   = person identity : added_by, modified_by, ...
        '/_old$/is', # Old IDs if apply

        '/_?extra_?/is', # anything "extra" field is for admin purpose only

        # Passwords are specials: you can show/hide.
        # Listing encypted passwords are not necessary
        # List unencrypted passwords are optional
        # But they have to appear in add/edit forms.
        # '/_?password$/is', # password = User passwords

        # Optionals, but they might have to appear in listing, add, edit, details pages.
        # '/_type$/is', # _type = data identifiers or some meta data : property_type
        '/^lang_/is', # lang_ = Language configuration
        '/^language_?/is', # language_ = Language configuration

        '/^browser_/is', # browser_isp, browser_agent
        '/_surrogate$/is', # plaintiff_surrogate: Additional column to hold the copy of parent column name
    );
    /**
     * Fields that require long data entry fields / textarea
     */
    private $long_regex = array(
        '/_answers?$/is', # eg: faq_answer
        '/_articles?$/',
        '/_audio$/is', # Embedded Audio HTML
        '/_body$/', # message_body
        '/_casestudy$/is', # case study text
        # '/_comments?$/is', # Optional, it could be short input as well
        '/_contents?$/is',
        #'/date_?$/is', # Records and other dates
        '/_definitions$/is', # glossary_definition
        '/_description_short$/is', # short descriptions superseding description
        '/_descriptions?$/is', # category_description
        '/_details$/is', # product_details
        '/_excerpts?$/is', # category_description
        '/_feature?$/is', # category_description
        '/json$/is', # JSON data
        '/_htmls?$/is', # email_html
        '/_intro/is', # partial match for introduction, introductory, ...
        '/_long_/is', # eg. user_long_description
        '/_long$/is', # eg. user_long_description (@todo stay away from longitude)
        '/_memo$/is',
        '/_messages?$/is',
        '/_narration?$/is',
        '/_news$/is',
        '/_opinions?$/is', # Opinions as a long text by someone
        '/_policy?$/is', # Policy descriptions
        '/_sqls?$/is', # Multipurpose full SQL body
        '/_texts?$/is', # message_text
        '/_toc$/is',
        '/_video$/is', # Embedded Video HTML
    );
    /**
     * Some words need to appear in uppercase
     * @see cruder.sqlite
     */
    private $uppers = array(
        'alr', # American Law Reports
        'amt', # Amount
        'api', # Application Programming Interface
        'cdn', # Content Delivery Network
        'crbt', # Caller's Ring Back Tone
        'crud', # Create, Read, Update, Delete - operations
        'css', # Cascading Style Sheets
        'db', # Database
        'dob', # Date of Birth
        'dod', # Date of Death (died on)
        'faq', # Frequently Asked Questions
        'ftp', # File Transfer Protocol
        'gpa', # Grade Point Average
        'html', # Hyper Text Markup Language
        'http', # Hyper Text Transmission Protocol
        'iata', # International Air Transport Association
        'ic', # Identity Card
        'icao', # International Civil Aviation Organization
        'id', # Identity Number
        'im', # Chat IDs and Instant Messaging
        'ip', # Internet Protocol (Address)
        'irc', # Internet Relay Chat
        'isbn', # International Standard Book Number
        'isp', # Internet Service Provider
        'mime', # Multipurpose Internet Mail Extensions
        'msn', # Microsoft Network
        'nric', # National Registration Identity Card (Singapore)
        'ns', # Name Server
        'pan', # Permanent Account Number
        'pc', # Piece
        'pcs', # Pieces
        'pdf', # PDF document
        'pk', # Primary Key
        'poc', # Proof Of Concet, Point Of Contact
        'prbt', # Personalised Ring Back Tone
        'qr', # Quick Response Code
        'qty', # Quantity
        'rgb', # Red Green Blue
        'smtp', # Simple Mail Transfer Protocol
        'sn', # Serial Number
        'sql', # SQL
        'toc', # Table of Contents
        'uri', # Uniform Resource Index
        'url', # Uniform Resource Locator
        'vat', # Value Added Tax
        'xml', # Extensible Markup Language (XML)
        'xref', # Cross Reference, generally a URL
        'zip', # Zone Improvement Planning
    );

    /**
     * Generate the source codes
     *
     * @param int $subdomain_id
     * @param string $entity_name
     * @param string $__ENTITY_FULLNAME__
     * @param bool $produce_files
     *
     * @return bool
     */
    public function generate_codes($subdomain_id = 0, $entity_name = "", $__ENTITY_FULLNAME__ = "", $produce_files = false)
    {
        $subdomain_id = (int)$subdomain_id;
        if ($subdomain_id == 0) {
            \common\stopper::message('Please choose a correct Subdomain ID.');
        }

        $variable = new \common\variable();

        # Success parameter to return later on
        $success = true;

        # Sanitize the entity name
        $this->entity_name = $entity_name = \common\tools::sanitize($entity_name);
        $__ENTITY_FULLNAME__ = htmlentities($__ENTITY_FULLNAME__);

        $mt = new \backend\mysql_table();
        $entity_name_singular = $mt->singular($this->entity_name);

        $template_location = "{$entity_name}"; # for SQL making, older: my:-:templates/$entity_name

        $subdomain_sql = "
SELECT
	subdomain_id,
	subdomain_name
FROM query_subdomains
WHERE
	subdomain_id={$subdomain_id}
	AND is_active='Y'
;";
        $subdomain = $this->row($subdomain_sql);
        if (!isset($subdomain['subdomain_name'])) {
            # Warning: This is not good to use the default framework.
            \common\stopper::message('Subdomain details is not available for ID: ' . $subdomain_id);
            $subdomain = array(
                'subdomain_id' => 0,
                'subdomain_name' => $_SERVER['SERVER_NAME'],
            );
        }
        #$subdomain_id = (int)$subdomain['subdomain_id'];
        $subdomain_name = $subdomain['subdomain_name'];

        # Customize a base location of this "framework" to write/export files to.
        $framework = new \backend\framework();
        $subdomain_base = $framework->subdomain_base($subdomain_id);

        $class = "{$subdomain_base}/classes";
        $controller = "{$subdomain_base}/controllers";
        $validator = "{$subdomain_base}/js/validators/{$entity_name}";
        $template = "{$subdomain_base}/templates";
        $image = "{$subdomain_base}/templates/images";
        $css = "{$subdomain_base}/templates/css";
        $js = "{$subdomain_base}/js";

        /**
         * Requrements: This section builds a list of files to copy into other locations.
         */

        # Define, which files are being written where
        # To duplicate a samme file, wrap with @...@
        # eg.
        # 'null.php'   => "{$template}/null.php",
        # '@null.php@' => "{$template}/blank.php",
        $files = array(
            # Install the CRUDed class model
            'classes/class.entity.inc.php' => "{$class}/class.{$entity_name}.inc.php",

            # Controllers for administrative purposes
            'controllers/entity/list.php' => "{$controller}/{$entity_name}/list.php",
            'controllers/entity/add.php' => "{$controller}/{$entity_name}/add.php",
            'controllers/entity/edit.php' => "{$controller}/{$entity_name}/edit.php",
            'controllers/entity/delete.php' => "{$controller}/{$entity_name}/delete.php",
            'controllers/entity/details.php' => "{$controller}/{$entity_name}/details.php",
            'controllers/entity/sort.php' => "{$controller}/{$entity_name}/sort.php",
            'controllers/entity/flag.php' => "{$controller}/{$entity_name}/flag.php",
            'controllers/entity/singular.php' => "{$controller}/{$entity_name_singular}.php",
            'controllers/entity/blockaction.php' => "{$controller}/{$entity_name}/blockaction.php",

            # Copy of controllers for public data distribution
            'controllers/entity/list-public.php' => "{$controller}/{$entity_name}.php", # Install on the parent directory
            'controllers/entity/search.php' => "{$controller}/{$entity_name}/search.php", # Search script is alike the listing page
            'controllers/entity/search-public.php' => "{$controller}/{$entity_name}/search-public.php", # Public search script is alike the listing page
            '@controllers/entity/details.php@' => "{$controller}/{$entity_name}/details-public.php",

            # Templates for administrative purposes
            'templates/entity/add.php' => "{$template}/{$entity_name}/add.php",
            'templates/entity/edit.php' => "{$template}/{$entity_name}/edit.php",
            'templates/entity/list.php' => "{$template}/{$entity_name}/list.php",
            'templates/entity/details.php' => "{$template}/{$entity_name}/details.php",

            # Templates for public data distribution
            'templates/entity/list-public.php' => "{$template}/{$entity_name}/list-public.php",
            'templates/entity/details-public.php' => "{$template}/{$entity_name}/details-public.php",

            # Singular (ID to Name conversion plugin)
            'plugins/modifier.singular.php' => "{$subdomain_base}/plugins/modifier.$entity_name_singular.php",

            # The core management templates
            'templates/frontend.php' => "{$template}/frontend.php", # Frontend user page
            'templates/admin.php' => "{$template}/admin.php", # Backend admin page
            'templates/admin-mobile.php' => "{$template}/admin-mobile.php", # Backend admin page
            'templates/null.php' => "{$template}/null.php",
            'templates/blank.php' => "{$template}/blank.php",
            'templates/404.php' => "{$template}/404.php",

            # CSS files
            'templates/css/404.css' => "{$template}/css/404.css",
            'templates/css/login.css' => "{$template}/css/login.css",
            'templates/css/menu.css' => "{$template}/css/menu.css",
            'templates/css/messenger.css' => "{$template}/css/messenger.css",
            'templates/css/search-form.css' => "{$template}/css/search-form.css",
            'templates/css/management.css' => "{$template}/css/management.css",
            '@templates/css/management.css@' => "{$template}/css/mobile.css",
            'templates/css/error-messages.css' => "{$template}/css/error-messages.css",
            'templates/{c_url}/css/management.css' => "{$template}/{c_url}/css/management.css",

            # Force creating the images directory
            'templates/images/blank.png' => "{$template}/images/{$entity_name}/default.png",
            '@templates/images/blank.png@' => "{$template}/images/{$entity_name}/thumbs/default.png",

            # Login management
            'templates/login.php' => "{$template}/login.php", # Login template
            'controllers/logout.php' => "{$controller}/logout.php",
            'controllers/login.php' => "{$controller}/login.php",
            'controllers/captcha.php' => "{$controller}/captcha.php",
            'templates/includes/login.php' => "{$template}/includes/login.php",
            'templates/password/change.php' => "{$template}/password/change.php",
            'controllers/password/change.php' => "{$controller}/password/change.php",
            'controllers/password/forgot.php' => "{$controller}/password/forgot.php",
            'classes/class.login_manager.inc.php' => "{$class}/class.login_manager.inc.php",

            # Othe default pages that should be explicitly registered for each websites
            'js/contact-us.js' => "{$js}/contact-us.js",
            'js/google-analytics.js' => "{$js}/google-analytics.js",
            'controllers/contact-us.php' => "{$controller}/contact-us.php",
            'templates/includes/contact-us.php' => "{$template}/includes/contact-us.php",

            # Javascript validators: Create blank files
            # {$validator}: on the parent.
            # {$js}: within the subdomain pack
            'js/validators/entity/add.js' => "{$js}/validators/{$entity_name}/add.js",
            'js/validators/entity/edit.js' => "{$js}/validators/{$entity_name}/edit.js",
            'js/validators/entity/list.js' => "{$js}/validators/{$entity_name}/list.js",

            # readme.txt files
            'readme/js.txt' => "{$js}/readme.txt",
            'readme/configs.txt' => "{$subdomain_base}/configs/readme.txt",
            'readme/plugins.txt' => "{$subdomain_base}/plugins/readme.txt",
            'readme/templates.txt' => "{$template}/readme.txt",
            'readme/classes.txt' => "{$class}/readme.txt",
            'readme/images.txt' => "{$image}/readme.txt",
            'readme/controllers.txt' => "{$controller}/{$entity_name}/readme.txt",
            'readme/entity.txt' => "{$template}/{$entity_name}/readme.txt",
            'readme/css.txt' => "{$css}/readme.txt",
            'readme/home.txt' => "{$subdomain_base}/readme.txt",
            'readme/controllers-parent.txt' => "{$controller}/readme.txt",

            '.htaccess' => "{$subdomain_base}/.htaccess",
            'index.php' => "{$subdomain_base}/index.php",
            'config.php' => "{$subdomain_base}/config.php",
            'robots.txt' => "{$subdomain_base}/robots.txt",
            'configs/__subdomain_name__.conf' => "{$subdomain_base}/configs/{$subdomain_name}.conf", # Does not work

            # Developer's comments that will be patched in CRUDed files
            'developers/comments.txt' => "{$subdomain_base}/developers/comments.txt",
            'developers/authors.txt' => "{$subdomain_base}/developers/authors.txt",
            'developers/url.txt' => "{$subdomain_base}/developers/url.txt",

            # Error messages do not require physical templates.
            # They are served as static contents from the database

            # Additionals (for the new theme)
            # Save resource copying time by moving them to the parent directories.
            # Do not ask foro CRUDer if possible, to copy these files.

            # Particulalry unspecified, unstable resources that may change in the future
            'images/login-background.png' => 'images/login-background.png',
            'images/login-key.png' => 'images/login-key.png',

            # For Theme02 template version
            #'templates/images/background-top.png'  => "{$template}/images/background-top.png",
            #'templates/images/background-navigator.png'  => "{$template}/images/background-navigator.png",
            #'templates/images/background-content.png'  => "{$template}/images/background-content.png",
            'templates/images/logo.png' => "{$template}/images/logo.png",
            #'templates/images/sprites.png' => "{$template}/images/sprites.png",
            #'templates/images/sprites-small.png' => "{$template}/images/sprites-small.png",

            #'js/theme02/menus-dropdown.js'  => "{$js}/theme02/menus-dropdown.js",
            #'js/menus-dropdown.js'  => "{$js}/menus-dropdown.js",
        );

        # Just in the parent of this file, there is a CRUDER directory
        $templates_path = __LIBRARY_PATH__ . '/cruder';
        $__PROTECTION_CODE__ = md5(mt_rand(1000, 9999) . microtime());
        $__TIMESTAMP__ = date('Y-m-d H:i:s ') . mt_rand(100, 999);

        $entity = $variable->post('entity', 'array', array());
        $pk_name = $variable->read($entity, 'pk_name', 'string', "");
        $table = $variable->read($entity, 'table_name', 'string', "");

        # Begin reading columns
        $columns = $this->columns($table);
        $production_level_column_heads = array_filter(array_map(array(&$this, '_production_level_column_head'), $columns));
        #print_r($production_level_column_heads); var_dump($production_level_column_heads); print_r($columns); die();
        $columns_tr = array();
        $data_rows = array();

        $COLUMN_HEADERS = array();
        $COLUMN_DATA = array();
        $COLUMN_EMPTY = array();
        $JAVASCRIPT_ADD_FIELDS = array();
        $JAVASCRIPT_EDIT_FIELDS = array();

        $schema = new \backend\schema();
        $schema->database(MYSQL_DATABASENAME);
        foreach ($columns as $c => $column) {
            # __ENTITY__ = $entity
            $column_name = $this->column_name($column);
            $html_name = "{$entity['name']}[$column]";
            $html_id = "{$entity['name']}-{$column}"; # To help a developer write Javascripts externally for a particular element

            /**
             * Column comments (from the database) will appear has hints in the add/edit forms
             */
            $column_comments_full = $schema->column_comments($table, $column);
            $column_comments_chunks = explode('|', $column_comments_full);
            $column_comments_chunks = array_map('trim', $column_comments_chunks);
            $column_comments = $column_comments_chunks[0];
            $column_comments = htmlentities($column_comments);
            $column_comments = addslashes($column_comments);
            /**
             * Default value assigned in Table Comments or, Safe Column Name
             */
            $placeholder = count($column_comments_chunks) > 1 ? $column_comments_chunks[1] : addslashes($column_name);

            # Used in generating HTML Forms for add/edit.
            if ($this->production_level_column_heads($column)) {
                if ($this->is_password_column($column)) {
                    # Password column
                    $columns_tr[] = "
<tr class=\"{cycle values='A,B'}\">
	<td class=\"attribute\">{$column_name}: <span class=\"required\">*</span></td>
	<td>
		<input type=\"password\" name=\"{$html_name}\" value=\"{\${$entity['name']}.$column|utf8}\" class=\"input\" id=\"{$html_id}\" placeholder=\"{$placeholder}\" />
		<span class=\"form-hints\">{$column_comments}</span>
	</td>
</tr>
";
                    $JAVASCRIPT_ADD_FIELDS[] = "v.addValidation('{$html_name}', 'required', '{$column_name} - please enter data');";
                    $JAVASCRIPT_ADD_FIELDS[] = "v.addValidation('{$html_name}', 'minlen=5', '{$column_name} - should be least 5 characters long');";
                    $JAVASCRIPT_EDIT_FIELDS[] = "v.addValidation('{$html_name}', 'required', '{$column_name} - please enter data');";
                } else if ($this->is_file_column($column)) {
                    # File upload field
                    $columns_tr[] = "
<tr class=\"{cycle values='A,B'}\">
	<td class=\"attribute\">{$column_name}: <span class=\"required\">*</span></td>
	<td>
		<!-- normal data editor -->
		<input type=\"text\" name=\"{$html_name}\" value=\"{\${$entity['name']}.$column|utf8}\" class=\"input\" id=\"{$html_id}\" />
		<span class=\"form-hints\">
			<div>
				{$column_comments} |
				<a target=\"preview\" href=\"images/{$entity['name']}/{\${$entity['name']}.$column|escape:'url'}\">Preview</a> |
				<a target=\"preview\" href=\"images/{$entity['name']}/thumbs/{\${$entity['name']}.$column|escape:'url'}\">Thumbnail</a>
			</div>
			<div><img class=\"{$entity['name']}-{$html_name}-preiview\" src=\"images/{$entity['name']}/{\${$entity['name']}.$column|escape:'url'}\" /></div>
		</span>
	</td>
</tr>
<tr class=\"{cycle values='A,B'}\">
	<td class=\"attribute\">&nbsp;</td>
	<td>
		<!-- file replacement via upload -->
		<span id=\"{$html_id}-upload\">
			<input type=\"file\" name=\"{$column}\" value=\"{\${$entity['name']}.$column|utf8}\" class=\"file\" id=\"{$html_id}-file\" placeholder=\"{$placeholder}\" />
		</span>
		<span class=\"form-hints\">
			Or, upload a file now |
			<a href=\"#\" onclick=\"return !(document.getElementById('{$html_id}-upload').innerHTML=document.getElementById('{$html_id}-upload').innerHTML);\">Cancel upload</a>
		</span>
	</td>
</tr>
";
                    $JAVASCRIPT_ADD_FIELDS[] = "//v.addValidation('{$html_name}', 'required', '{$column_name} - please upload a file');";
                    $JAVASCRIPT_EDIT_FIELDS[] = "//v.addValidation('{$html_name}', 'required', '{$column_name} - please upload a file');";
                } else if ($this->is_long_text_column($column)) {
                    # Produce a big text area optionally with TinyMCE
                    # class "textarea/plaintext": Plain text area
                    # class "editor"  : TinyMCE editor area
                    # rows and cols are required for w3c validation only. But we will control the actual size via CSS.

                    $editor_class = preg_match('/_(sql|text|code)$/is', $column) ? 'plaintext' : 'editor';

                    $columns_tr[] = "
<tr class=\"{cycle values='A,B'}\">
	<td class=\"attribute\">{$column_name}: <span class=\"required\">*</span></td>
	<td class=\"value\">
		<div><textarea rows=\"5\" cols=\"75\" name=\"{$html_name}\" class=\"{$editor_class}\" id=\"{$html_id}\" placeholder=\"{$placeholder}\">{\${$entity['name']}.{$column}|utf8}</textarea></div>
		<div><span class=\"form-hints\">{$column_comments}</span></div>
	</td>
</tr>
";
                    if (!$this->javascript_skip_field($column)) {
                        # Allow clean field names
                        $JAVASCRIPT_ADD_FIELDS[] = "v.addValidation('{$html_name}', 'required', '{$column_name} - please enter data');";
                        $JAVASCRIPT_EDIT_FIELDS[] = "v.addValidation('{$html_name}', 'required', '{$column_name} - please enter data');";
                    } else {
                        # Avoid some fields that might be skipped validating.
                        $JAVASCRIPT_ADD_FIELDS[] = "//v.addValidation('{$html_name}', 'required', '{$column_name} - please enter data');";
                        $JAVASCRIPT_EDIT_FIELDS[] = "//v.addValidation('{$html_name}', 'required', '{$column_name} - please enter data');";
                    }
                } else {
                    # Variable modification via "|utf8" is not required all the times. Use responsibly.
                    # Require small input area
                    $columns_tr[] = "
<tr class=\"{cycle values='A,B'}\">
	<td class=\"attribute\">{$column_name}: <span class=\"required\">*</span></td>
	<td>
		<input type=\"text\" name=\"{$html_name}\" value=\"{\${$entity['name']}.$column|utf8}\" class=\"input\"
		id=\"{$html_id}\" placeholder=\"{$placeholder}\" />
		<span class=\"form-hints\">{$column_comments}</span>
	</td>
</tr>
";
                    $JAVASCRIPT_ADD_FIELDS[] = "v.addValidation('{$html_name}', 'required', '{$column_name} - please enter data');";
                    $JAVASCRIPT_EDIT_FIELDS[] = "v.addValidation('{$html_name}', 'required', '{$column_name} - please enter data');";

                    # Predict for other types of validations
                    # We may have to modify the javascript validator first to use these flags
                    # In case we do not need validations, for example in admin edits, just add remarks there
                    # If the fields were manually removed, you too have to remove their corresponding javascript validators

                    # Check for email address or username for the javascript validations
                    if (preg_match('/email$/', $html_name)) {
                        $JAVASCRIPT_ADD_FIELDS[] = "v.addValidation('{$html_name}', 'email', '{$column_name} - should be a valid email address');";
                        $JAVASCRIPT_EDIT_FIELDS[] = "v.addValidation('{$html_name}', 'email', '{$column_name} - should be a valid email address');";
                    }

                    # In case of username, ask for an email address
                    if (preg_match('/username|user_name/', $html_name)) {
                        $JAVASCRIPT_ADD_FIELDS[] = "v.addValidation('{$html_name}', 'email', '{$column_name} - better to have your email address here');";
                        $JAVASCRIPT_EDIT_FIELDS[] = "v.addValidation('{$html_name}', 'email', '{$column_name} - better to have your email address here');";
                    }

                    # Predict for date field
                    if (preg_match('/(date|dob|_on|since)/', $html_name)) {
                        $JAVASCRIPT_ADD_FIELDS[] = "//v.addValidation('{$html_name}', 'date', '{$column_name} - should be a date - YYYY-MM-DD');";
                        $JAVASCRIPT_EDIT_FIELDS[] = "//v.addValidation('{$html_name}', 'date', '{$column_name} - should be a date - YYYY-MM-DD');";
                    }
                }

                # Single line display
                # $data_rows[] = "<div><strong>{$column_name}</strong>: {\${$entity_name}.{$column}}</div>";
                # Or, use multi-line display with CSS controls (.details, .holder, .title, .content)

                # Used in producing the data details
                # Hide the password fields in the details pages
                if (!$this->is_password_column($column)) {
                    if ($this->is_file_column($column)) {
                        # Give a link to preview/download the uploaded images
                        $data_rows[] = "
<div class=\"holder\">
	<div class=\"title\">{$column_name}</div>
	<div class=\"content\">
		{\${$entity_name}.{$column}|default:'-'} |
		<a target=\"preview\" href=\"images/{$entity_name}/{\${$entity_name}.{$column}}\">Preview</a> |
		<a target=\"preview\" href=\"images/{$entity_name}/thumbs/{\${$entity_name}.{$column}}\">Thumbnail</a>
	</div>
</div>
";
                    } # Check for email address or username for the javascript validations
                    else if (preg_match('/email$/', $column)) {
                        # Safe guard the email addresses when printed in the pages
                        $data_rows[] = "
<div class=\"holder\">
	<div class=\"title\">{$column_name}</div>
	<div class=\"content\">{\${$entity_name}.{$column}|safe}</div>
</div>
";
                    } else {
                        # Display the column details normally
                        $data_rows[] = "
{if \${$entity_name}.{$column}}
<div class=\"holder\">
	<div class=\"title\">{$column_name}</div>
	<div class=\"content\">{\${$entity_name}.{$column}}</div>
</div>
{/if}
";
                    }
                }
            }

            # Production level filter: Used in listing the data columns
            if ($this->production_level_column_heads($column)) {
                # Avold long text fields, passwords and file fields in the listings
                if (
                    !$this->is_long_text_column($column)
                    && !$this->is_password_column($column)
                    && !$this->is_file_column($column)
                ) {
                    $COLUMN_HEADERS[] = "<th><a href=\"?sort={$column}\">{$column_name}</a></th>";
                    $COLUMN_DATA[] = "<td>{\${$entity['name']}s[l].{$column}}</td>"; # Plural form
                    $COLUMN_EMPTY[] = "<td>-</td>";
                }
            }
        }
        # Within the FORM tags
        $__TR__ = implode("", $columns_tr);

        # In details pages
        $__DATA_ROWS__ = implode("\r\n", $data_rows);

        # In listing pages
        $__COLUMN_HEADERS__ = implode("\r\n\t\t", $COLUMN_HEADERS); # Table column header
        $__COLUMN_DATA__ = implode("\r\n\t\t", $COLUMN_DATA); # Table data/body
        $__COLUMN_EMPTY__ = implode("\r\n\t\t", $COLUMN_EMPTY); # {sectionelse} portion. Empty value = do not produce it.
        # End of reading columns

        $__SEARCHFIELDS__ = implode(" LIKE '%{\$search_{$entity['name']}}%'\r\n\t\tOR e.", $production_level_column_heads);

        $__FIELDS_ADD__ = $this->fields_associative($columns);
        $__FIELDS_EDIT__ = $this->fields_associative($columns);
        $__FIELDS_LIST__ = $this->fields_associative_listing($columns);

        /**
         * @todo Make Key/Vale pair
         */
        $find = array(
            '__SUBDOMAIN_ID__',
            '__SUBDOMAIN_NAME__',
            '__ENTITY__', # Which DB Entity is being written?
            '__SINGULAR__', # Singular (calculated name of the entity)
            '__ENTITY_FULLNAME__', # Full name of this entity
            '__TABLE__', # Table Name
            '__PK_NAME__', # Primary Key Column Name
            '__PROTECTION_CODE__', # Protection Code
            '__TIMESTAMP__', # Time Stamp / File Creation
            '__TEMPLATE__', # Template location

            '#__DEVELOPER-COMMENTS__', # Developer's messages in the head of the files
            '__AUTHOR__',
            '__URL__',

            # HTML replacement
            '__TR__',
            '__DATA_ROWS__',
            '__COLUMN_HEADERS__',
            '__COLUMN_DATA__',
            '__COLUMN_EMPTY__',

            # For self validations
            '__FIELDS_ADD__', # In *-add.php
            '__FIELDS_EDIT__', # In *-edit.php
            '__FIELDS_LIST__', # In *-list.php

            # Self create search fields in the search pages
            '__SEARCHFIELDS__', # *-search.php

            # Javascripts replacement
            '__JAVASCRIPT_ADD_FIELDS__',
            '__JAVASCRIPT_EDIT_FIELDS__',
        );
        $replace = array(
            $subdomain_id,
            $subdomain_name,
            $entity_name,
            $entity_name_singular,
            $__ENTITY_FULLNAME__,
            $table,
            $pk_name,
            $__PROTECTION_CODE__,
            $__TIMESTAMP__,
            $template_location,

            # Comments / Developer's messages and application links are defined externally.
            # This feature is added to customize an application's comments.
            \common\tools::file_contents($subdomain_base . '/developers/comments.txt', $templates_path . '/developers/comments.txt'),
            \common\tools::file_contents($subdomain_base . '/developers/authors.txt', $templates_path . '/developers/authors.txt'),
            \common\tools::file_contents($subdomain_base . '/developers/url.txt', $templates_path . '/developers/url.txt'),

            # List of columns in each HTML Rows, for a table
            $__TR__,
            $__DATA_ROWS__,
            $__COLUMN_HEADERS__,
            $__COLUMN_DATA__,
            $__COLUMN_EMPTY__,

            $__FIELDS_ADD__,
            $__FIELDS_EDIT__,
            $__FIELDS_LIST__,

            $__SEARCHFIELDS__,

            # Javascripts replacement
            implode("\r\n", $JAVASCRIPT_ADD_FIELDS),
            implode("\r\n", $JAVASCRIPT_EDIT_FIELDS),
        );

        # Orderly list the possible CRUDer template locations.
        $cruder_templates = array(
            # Customized CRUDer templates within the base of a subdomain
            # This is a default area from where we can expect almost all files.
            $subdomain_base . '/cruder',

            # In worst case, draw the system default templates
            $templates_path,
        );

        $counter = 0;
        foreach ($files as $file_original => $file_target) {
            ++$counter;
            echo("<h1><strong>{$counter}.</strong> {$file_original}</h1>");

            # Also, lone a source (index) file to multiple targets (values)
            # Avoid the invalid characters and get the path of source file.
            $file_original = preg_replace('/[^a-z0-9\.\-\_\/\{\}]+/', "", $file_original);

            $fc_original = "";
            foreach ($cruder_templates as $ct => $path) {
                $expected_file = $path . '/' . $file_original;
                if (is_file($expected_file)) {
                    $fc_original = file_get_contents($expected_file);
                    echo("<p class='writing using'><strong>Using</strong>: {$expected_file}</p>");
                    break;
                }
                echo("<p class='skipping'><strong>Skipping</strong>: {$expected_file}</p>");
            }

            echo("<p class='writing'><strong>Seeking</strong>: {$templates_path}/{$file_original}</p>");
            echo("<p class='writing'><strong>Writing</strong>: {$file_target}</p>");
            $fc_write = str_replace($find, $replace, $fc_original);
            echo "<div class='highlight'>";
            if (!preg_match('/\.(jpg|gif|png)$/', $file_target)) {
                highlight_string($fc_write);
            } else {
                echo '<p>Skipped: Media file</p>';
            }
            echo "</div>";

            /**
             * Do not overwrite the existing files - these files might be MANUALLY maintained.
             */
            if (!file_exists($file_target)) {
                # Write the file: DANGEROUS AGAIN
                if ($produce_files === true) {
                    #\common\tools::make_directory(dirname($file_target));
                    /**
                     * @todo On linux systems, the attempt to make directories may fail. Handle errors with more cautions.
                     */
                    $parent = dirname($file_target);
                    if (!is_dir($parent)) {
                        mkdir($parent, 0777, true);
                    }
                    file_put_contents($file_target, $fc_write);
                }
            } else {
                echo("<p class='writing'><strong>SKIPPED</strong>: {$file_target}</p>");
            }
        }

        echo("<h1>Other pages and SQL operations</h1>");

        # List SQL Entries essential to create these files active.
        $sql_patch_file = "{$templates_path}/sqls/install-entity.sql"; # Read patches from this file.
        if (file_exists($sql_patch_file)) {
            # Make the SQL installer queries
            $sql = str_replace($find, $replace, file_get_contents($sql_patch_file));

            # Replace counter counter flags
            $this->callback_counter(true); # Reset to zero
            $sql = preg_replace_callback('/__COUNTER__/', array($this, 'callback_counter'), $sql);

            # Write the SQL Installer
            $sql_directory = "{$subdomain_base}/sqls";
            \common\tools::make_directory($sql_directory);
            $installer_sql_file = "{$sql_directory}/install-{$entity_name}.sql";
            if (!file_exists($installer_sql_file)) {
                if ($produce_files === true) {
                    file_put_contents($installer_sql_file, $sql);
                }
            }

            # Print out the installer SQL
            echo("<p class='writing'><strong>Add Pages/SQL</strong>: {$sql_patch_file}: Please enter these SQLs manually...</p>");
            echo "<div class='highlight sql'>";
            highlight_string($sql);
            echo "</div>";
        }


        # Register default pages
        $sql_patch_file = "{$templates_path}/sqls/default-pages.sql"; # Read patches from this file.
        #die($sql_patch_file);
        if (file_exists($sql_patch_file)) {
            # Make the SQL installer queries
            $sql = str_replace($find, $replace, file_get_contents($sql_patch_file));

            # Replace counter counter flags
            $this->callback_counter(true); # Reset to zero
            $sql = preg_replace_callback('/__COUNTER__/', array($this, 'callback_counter'), $sql);

            # Write the SQL Installer
            $sql_directory = "{$subdomain_base}/sqls";
            \common\tools::make_directory($sql_directory);
            $installer_sql_file = "{$sql_directory}/default-pages.sql";
            #die("Write: {$sql_directory}/default-pages.sql");
            if (!file_exists($installer_sql_file)) {
                if ($produce_files === true) {
                    file_put_contents($installer_sql_file, $sql);
                }
            }

            # Print out the installer SQL
            echo("<p class='writing'><strong>Default pages/SQL</strong>: {$sql_patch_file}: Please enter these SQLs manually once...</p>");
            echo "<div class='highlight sql'>";
            highlight_string($sql);
            echo "</div>";
        }

        return $success;
    }

    /**
     * Readability formatted column names - to be printed as heads
     *
     * @param string $column_name
     *
     * @return string
     */
    private function column_name($column_name = "")
    {
        # Pre filters: some words appear as single word - but they are composed of multiple small words
        $replaces = array(
            '/casestudy/is' => 'case study',
            '/description_short/is' => 'short description', # reverse it
            '/teamsize/is' => 'team size',

            '/code$/is' => '/ code/', # zip code, post code, postal code, redemption code
            '/name$/is' => '/ name/', # theme name, full name, first name, user name
            '/password$/is' => '/ password/', # loginpassword => login password
            '/string$/is' => '/ string', # querystring => query string
            '/_dob$/is' => '/ Date of Birth', # client_dob => Client Date of Birth
        );
        $column_name = preg_replace(array_keys($replaces), array_values($replaces), $column_name);

        # Now, break down the words and make multiples
        $words = preg_split('/[^a-z0-9]+/i', $column_name);
        $words = array_filter($words);
        $words = array_map('ucfirst', $words);

        # Remove the matching CRUDer name if used as a prefix.
        $mt = new \backend\mysql_table();
        if (isset($words[0]) && strtolower($mt->singular($this->entity_name)) == strtolower($words[0])) {
            unset($words[0]);
        }

        foreach ($words as $w => $word) {
            if (in_array(strtolower($word), $this->uppers)) {
                $words[$w] = strtoupper($word);
            }
        }

        return implode(' ', $words);
    }

    /**
     * Filters column heads by guessing, for quick production.
     * This confirms our own standards only. You can do it with your own.
     *
     * @param string $column
     *
     * @return bool True/False about if the column is in production
     */
    private function production_level_column_heads($column = "")
    {
        # Remarks:
        # We do not assume that `id` is a primary key.
        # Rather, it is `entity_id`, where the word `entity` represents the name of the main object.

        # Not necessary, because the field names come directly from the database meta data only.
        # $column = strtolower($column);
        # $column = preg_replace('/[^a-z0-9\_]/', "", $column);

        $valid_column_head = true;

        if (in_array(strtolower($column), $this->unacceptable_names)) {
            $valid_column_head = false;

            return $valid_column_head;
        }

        foreach ($this->invalid_names_regex as $i => $regex) {
            if (preg_match($regex, $column)) {
                # Stop on the first valid match
                $valid_column_head = false;
                break;
            }
        }

        return $valid_column_head;
    }

    /**
     * This field requires a password (masked input)
     *
     * @param string $column_name
     *
     * @return bool
     */
    private function is_password_column($column_name = "")
    {
        # This name can be located anywhere
        # password_xxx, input_password_xxx, ...
        # Use one pattern only
        #$is_password = (preg_match('/_password$/i', $column_name) >= 1);
        $is_password = (preg_match('/password/i', $column_name) >= 1);

        return $is_password;
    }

    /**
     * This field will browse a local file
     * Examples: file_, _image, _thumbnail, _picture, _attachment
     *
     * @param string $column_name
     *
     * @return bool
     */
    private function is_file_column($column_name = "")
    {
        /**
         * These field names may not need file uploader.
         * They are system-wide used normal fields that might be matched as file-uploader later this method.
         */
        $false_names = array(
            'include_file',
            'template_file',
        );
        if (in_array($column_name, $false_names)) {
            return false;
        }

        /**
         * Rather reserve this flag for text mode using a hash commenting
         */
        $file_flags = implode('|', array(
            'attachment',
            'attachments',
            'attached',
            'document',
            'file',
            'files',
            'icon',
            'image',
            'logo',
            'picture',
            'photo',
            'photograph',
            'thumbnail',
        ));
        $is_file_column = preg_match('/_(' . $file_flags . ')$/is', $column_name) || preg_match('/^(' . $file_flags . ')_/is', $column_name);

        return $is_file_column;
    }

    /**
     * Determine if an input requires a long text area.
     * If so, it will install HTML Editor via tinyMCE
     *
     * @param string $column_name
     *
     * @return bool
     */
    private function is_long_text_column($column_name = "")
    {
        $long_text_column = false;

        # Need to skip these set of names
        if (in_array($column_name, array(
            'meta_description',
        ))
        ) {
            return false;
        }

        foreach ($this->long_regex as $r => $regex) {
            if (preg_match($regex, $column_name)) {
                $long_text_column = true;
                break;
            }
        }

        return $long_text_column;
    }

    /**
     * Javascript - Fields to skip validating in the javascript
     *
     * @param string $column_name
     *
     * @return int|boolean True: Skip this field, False: Validate this field
     */
    private function javascript_skip_field($column_name = "")
    {
        /**
         * Javascript won't check these fields.
         * Field names are part of clean regular expressions.
         * Keep this list as short as possible.
         */
        $javascript_skip_list = array(
            'extra',
            'fax',
            'file',
            'logo',
            'phone',
            'short',
            'tagline',
        );
        $is_javascript_skip = preg_match('/(' . implode('|', $javascript_skip_list) . ')/is', $column_name);

        return $is_javascript_skip;
    }

    /**
     * Build a list of columns for ADD/EDIT forms.
     * This list will be used as self validator.
     */
    private function fields_associative($columns = array())
    {
        $data = array();
        foreach ($columns as $c => $column) {
            if ($this->production_level_column_heads($column)) {
                $data[] = "'{$column}' => null,";
            }
        }

        return implode("\r\n\t\t\t\t", $data);
    }

    /**
     * Build a list of columns used in listing pages
     *
     * @param array $columns
     *
     * @return string
     */
    private function fields_associative_listing($columns = array())
    {
        $data = array();
        foreach ($columns as $c => $column) {
            if ($this->production_level_column_heads($column)) {
                # Avold long text fields
                if (!$this->is_long_text_column($column)) {
                    $data[] = "e.`{$column}`";
                }
            }
        }

        return implode(",\r\n\t", $data);
    }

    /**
     * Replaces a __COUNTER__ flag with number of repetitions called so far.
     * Examples: 1, 2, 3, ...
     *
     * @todo Make callback_counter method a part of cruder class.
     *
     * @param bool $reset
     *
     * @return int
     */
    private function callback_counter($reset = false)
    {
        static $counter = 0;

        if ($reset === true) {
            # Triple check for TRUE ===
            # Reset again, in a non-call back environment
            $counter = -1;
        }

        ++$counter;

        return $counter;
    }

    /**
     * Save when an entity CRUD class was written?
     *
     * @param array $entity Name of the entity
     */
    public function save_records($entity = array())
    {
        /**
         * @todo Remove use of duplicate columns
         */
        $entity['name'] = \common\tools::sanitize($entity['name']);
        $crud = new \backend\crud();
        $crud->add(
            'query_cruded',
            array(
                'subdomain_id' => $entity['subdomain_id'],
                'cruded_on' => 'CURRENT_TIMESTAMP()',
                'full_name' => $entity['__ENTITY_FULLNAME__'], # Readable full name
                'crud_name' => $entity['name'],
                'table_name' => $entity['table_name'],
                'pk_name' => $entity['pk_name'],
                'is_active' => 'Y', # Record keeping only
                'is_approved' => 'Y', # Record keeping only
            ),
            array(
                'added_on' => 'CURRENT_TIMESTAMP()',
                'cruded_on' => 'CURRENT_TIMESTAMP()',
                'uninstalled_on' => 'CURRENT_TIMESTAMP()',
                'is_uninstalled' => 'N',
                'table_name' => $entity['table_name'],
                'pk_name' => $entity['pk_name'],
                'is_active' => 'Y', # Record keeping only
                'is_approved' => 'Y', # Record keeping only
            ),
            false,
            false
        );
    }

    /**
     * Uninstalls an entity: Removes Query Pages, Marks as uninstalled
     *
     * @todo Uninstallation of an entity files and database records
     *
     * @param string $entity_name
     */
    public function uninstall($entity_name = "")
    {
        $entity_name = \common\tools::sanitize($entity_name);
        /*
SELECT * FROM query_pages WHERE page_name LIKE '{$entity_name}-%';
DELETE FROM query_pages WHERE page_name LIKE '{$entity_name}-%';
UPDATE query_cruded SET
    uninstalled_on=CURRENT_TIMESTAMP(),
    is_uninstalled='Y'
WHERE
    crud_name='{$entity_name}'
;
        */

        # remove class files
        # remove controllers (including public one)
        # remove templates
        # Remove database entries (page names)
        # Remove database .sql file (installer)
        # Remove javascript validators
        # Remove all readme.txt files
        # Mark as removed or remove it permanently

        # Uninstall scripts (.bat, .sh, .sql)
        $UNINSTALL = array(
            'bat' => array(),
            'shell' => array(),
            'sql' => array(),
        );
        # "DELETE FROM query_pages WHERE subdomain_id={$subdomain_id} AND ( page_name LIKE '{$entity['name']}-%.php' OR page_name = '{$entity['name']}.php' );";
        # DEL /F /Q js\validators\{$entity['name']}\*.js
        # DEL /F /Q controllers\{$entity['name']}*.php
        # DEL /F /Q controllers\{$entity['name']}\*.php
        # DEL /F /Q controllers\{$entity['name']}\*.txt
        # DEL /F /Q templates\{$entity['name']}\*.txt
        # DEL /F /Q templates\{$entity['name']}\*.php
        # DEL /F /Q classes\class.{$entity['name']}.inc.php
        # DEL /F /Q sqls\{$entity['name']}.sql
        # RMDIR /S /Q templates\{$entity['name']}
        # RMDIR /S /Q controllers\{$entity['name']}
        # RMDIR /S /Q js\validators\{$entity['name']}
    }

    /**
     * Public interaction: Prints out the file contents in an exact way
     *
     * @param string $file
     */
    public function read_file($file = 'header.html')
    {
        $file = __LIBRARY_PATH__ . '/cruder/' . preg_replace('/[^a-z0-9\.\-]/is', "", $file);
        if (file_exists($file)) {
            readfile($file);
        }
    }

    /**
     * Filters column heads by guessing, for quick production.
     * This confirms our own standards only. You can do it with your own.
     *
     * @param string $column
     *
     * @return null|string Column name that can be used in production level
     */
    private function _production_level_column_head($column = "")
    {
        $valid_column_head = $column;

        if (in_array(strtolower($column), $this->unacceptable_names)) {
            return null;
        }

        foreach ($this->invalid_names_regex as $i => $regex) {
            if (preg_match($regex, $column)) {
                # Stop on the first valid match
                $valid_column_head = null;
                break;
            }
        }

        return $valid_column_head;
    }
}
