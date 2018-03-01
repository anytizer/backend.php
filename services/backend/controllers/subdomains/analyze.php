<?php
/**
 * Finds the extension of a file.
 * We will group the reports according to these file types.
 */
function extension($name = "")
{
    # apply only on files
    # if(!is_file($name)) return null; # checked already.

    $data = array();
    $extension = "";

    # Reading an extension - improved way.
    if (preg_match('/\.([a-z0-9]+)$/', $name, $data)) {
        $extension = strtolower($data[1]);
    }

    return $extension;
}

/**
 * @param string $dir Directory - First entry point
 * @param $sizes Integer Array - Bytes counted so far
 * @param $counters Integer Array - Number of files counted
 * @return null
 */
function size_r($dir = '/tmp', &$sizes, &$counters)
{
    if (!is_dir($dir)) {
        return null;
    }

    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if (in_array($file, array('.', '..', '.svn'))) {
                continue;
            }

            $physical = $dir . '/' . $file;
            if (is_file($physical)) {
                $extension = extension($file);

                # Forget unused things
                if (in_array($file, array('db', 'cok', 'tmp', 'log'))) {
                    continue;
                }

                switch ($extension) {
                    case 'htm':
                    case 'html':
                    case 'mht':
                        $index = 'html';
                    case 'htaccess':
                        $index = 'htaccess';
                        break;
                    case 'pdf':
                    case 'doc':
                    case 'docx':
                    case 'rtf':
                    case 'wri':
                        $index = 'readable-documents';
                        break;
                    case 'xls':
                    case 'xlsx':
                    case 'csv':
                        $index = 'reports';
                    case 'ppt':
                    case 'pps':
                    case 'pptx':
                        $index = 'presentation';
                        break;
                    case 'php':
                    case 'php3': # Poor, old php files, if any
                    case 'inc': # may be, used in third party tools
                    case 'class': # Ouch, stay away from java class files
                        $index = 'php';
                        break;
                    case 'txt':
                        $index = 'plain-texts';
                        break;
                    case 'css':
                        $index = 'css';
                        break;
                    case 'js':
                        $index = 'javascripts';
                        break;
                    case 'jpg':
                    case 'png':
                    case 'gif':
                    case 'ico':
                    case 'ai' :
                    case 'psd':
                        $index = 'images';
                        break;
                    case 'zip':
                    case 'gz':
                    case 'tar':
                    case 'rar':
                    case '7zip':
                    case 'ace':
                    case 'bz2':
                        $index = 'compressed-(archived-backup)';
                        break;
                    case 'sh':
                    case 'bat':
                        $index = 'batch-scripts';
                        break;
                    case 'sql':
                    case 'dmp':
                        $index = 'sqls';
                        break;
                    case 'mp3':
                    case 'flv':
                    case 'avi':
                    case 'mpg':
                    case 'mpeg':
                    case 'swf':
                    case 'qt':
                    case 'mov':
                    case 'dat':
                        $index = 'audio-video-media-files';
                        break;
                    case 'ini':
                    case 'cfg':
                    case 'conf':
                    case 'config':
                        $index = 'configurations';
                        break;
                    default:
                        # Debug what kind of file is this.
                        # echo $physical, ' - ', $extension, "\r\n";
                        $index = 'others';
                        break;
                }

                # Update the file size
                $size = filesize($physical);
                if (isset($sizes[$index])) {
                    $sizes[$index] += $size;
                } else {
                    $sizes[$index] = filesize($physical);
                }

                # Update the counter
                if (isset($sizes[$index])) {
                    ++$counters[$index];
                } else {
                    # Begin counting
                    $counters[$index] = 1;
                }
            } else if (is_dir($physical)) {
                # Call the self function with same parameters
                $current_recursive_function = __FUNCTION__;
                $current_recursive_function($physical, $sizes, $counters);
            }
        }
        closedir($handle);
    }
}

# What kinds of files?
# The keys will be used to render the names later on, in the templates.
$sizes = array(
    'audio-video-media-files' => 0,
    'batch-scripts' => 0,
    'compressed-(archived-backup)' => 0,
    'configurations' => 0,
    'css' => 0,
    'htaccess' => 0,
    'html' => 0,
    'images' => 0,
    'javascripts' => 0,
    'php' => 0,
    'plain-texts' => 0,
    'presentation' => 0,
    'readable-documents' => 0,
    'reports' => 0,
    'sqls' => 0,

    'others' => 0,
);

# Did we sort the array indices as we liked them to be?
# ksort($sizes);

# How many files? All reset to zero, initially
$counters = $sizes;

# Which sub-domain pack to analyze?
$sub-domain = new \subdomain\subdomains();
$subdomain_id = $variable->get('id', 'integer', 0);
$subdomain_base_dir = $framework->subdomain_base($subdomain_id);

if (!$subdomain_id) {
    \common\stopper::url('subdomain-not-analyzed.php');
}

size_r($subdomain_base_dir, $sizes, $counters);
$total = array_sum($sizes);

$smarty->assign('sizes', $sizes);
$smarty->assign('counters', $counters);
$smarty->assign('total', $total);
$smarty->assign('subdomain_id', $subdomain_id);
