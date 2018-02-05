<?php
namespace backend;

/**
 * Template to Database: Uses Templates table(query_templates).
 * @see Smarty Template Handling
 */
class template2db
    extends common\mysql
{
    private $subdomain_name = "";
    private $template_location = "";

    /**
     * @todo Fix this class file
     */
    public function __construct()
    {
        # Initiate mysql connection
        parent::__construct();
    }

    /**
     * Begin to read module name and location, immediately.
     */
    public function read($subdomain_name = "", $template_location = "")
    {
        if (!$subdomain_name) {
            \common\stopper::message('Must name a subdomain/module. Usage: (\$subdomain_name, \$template_location).');
        } else {
            $this->subdomain_name = $subdomain_name;
        }

        if (!is_dir($template_location)) {
            # \common\stopper::message
            throw new \Exception("Can not read templates at: <strong>{$template_location}</strong> Usage: (\$subdomain_name, \$template_location)");
        } else {
            # Make it Linux/Windows compatible
            $this->template_location = str_replace('\\', '/', $template_location);
        }
    }

    /**
     * Move the templates from file to the database
     */
    public function store_templates()
    {
        if ($handle = opendir($this->template_location)) {
            #echo "Directory handle: $handle\n";
            while (false !== ($file = readdir($handle))) {
                if (!preg_match('/^[a-z0-0\.\-\_]+\.php$/', $file)) {
                    # Templates should contain good name
                    continue;
                }
                echo "{$this->subdomain_name}: $file\n";

                # Move the contents into the database
                # Not necessary to clean up the old files.
                $import_template_sql = "
INSERT INTO query_templates (
	subdomain_name,
	file_name, file_comments,
	file_contents
) VALUES (
	'{$this->subdomain_name}',
	'{$file}', '{$file}',
	LOAD_FILE('{$this->template_location}/{$file}')
) ON DUPLICATE KEY UPDATE
	template_contents = LOAD_FILE('{$this->template_location}/{$file}')
;";
                $this->query($import_template_sql);
            }
            closedir($handle);
        }
    }


    /**
     * Move the templates from file to the database
     *
     * @todo Recursively loop through all the .php files inside a directory
     */
    public function store_all_files($location = '/tmp')
    {
        if ($handle = opendir($location)) {
            #echo "Directory handle: $handle\n";
            {
                {
                    {
                        while (false !== ($file = readdir($handle))) {
                            if (in_array($file, array('.', '..'))) {
                                {
                                    {
                                        continue;
                                    }
                                }
                            }

                            if (is_dir("{$location}/{$file}")) {
                                return $this->store_all_files("{$location}/{$file}");
                            }

                            if (!preg_match('/^[a-z0-0\.\-\_]+\.php$/', $file)) {
                                # Templates should contain good name
                                continue;
                            }
                            echo "{$this->subdomain_name}: $file\n";

                            # Move the contents into the database
                            # Not necessary to clean up the old files.
                            #$file_ctime
                            #$file_mtime
                            #$file_atime
                            # $file_size
                            $import_template_sql = "
INSERT INTO query_templates (
	subdomain_name,
	file_name, file_comments,
	file_contents
) VALUES (
	'{$this->subdomain_name}',
	'{$file}', '{$file}',
	LOAD_FILE('{$location}/{$file}')
) ON DUPLICATE KEY UPDATE
	template_contents = LOAD_FILE('{$location}/{$file}')
;";
                            $this->query($import_template_sql);
                        }
                    }
                }
            }
            closedir($handle);
        }
    }
}
