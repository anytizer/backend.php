<?php
require_once('../../inc.bootstrap.php');
require_once($backend['paths']['__LIBRARY_PATH__'] . '/inc/inc.config.php');

$db = new \common\mysql();
$subdomains_sql = "
SELECT
	subdomain_id,
	subdomain_name,
	is_protected
FROM query_subdomains
WHERE
	is_active='Y'

	# Publicly visible subdomains only
	AND is_hidden='N'

	# Hide aliased domains
	AND alias_id=0
ORDER BY
	subdomain_name
;";
$subdomains = $db->arrays($subdomains_sql);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Install by exporting</title>
    <link href="export.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper">
    <h1>Install by exporting a subdmain</h1>

    <p>You can isolate a sub-domain being from the core framework. This rebuilds a database for your subdomain. </p>

    <p>It carries both the <strong>Framework Database</strong> along with the records needed for the
        <strong>subdomain</strong> you will extract. </p>

    <h1>Privacy control</h1>

    <p>You cannot export a protected subdomain. Legends:</p>
    <ul>
        <li>Y - Yes, you can export it.</li>
        <li>N - No, you cannot export it.</li>
    </ul>
    <h1>Export now</h1>

    <p>Please choose a sub-domain to export. Exporting is perfectly harmless.</p>

    <form autocomplete="off" id="export-database" name="export-database" method="post" action="export.php">
        <table>
            <tr>
                <td class="r">Export Framework?</td>
                <td><input type="checkbox" name="framework" value="framework"
                           checked="checked"/> Avoiding framework means data only, and
                    <strong>not even</strong> the structures.
                </td>
            </tr>
            <tr>
                <td class="r">Subdomain:</td>
                <td><select name="subdomain_id" style="width:205px;">
                        <?php
                        foreach ($subdomains as $s => $subdomain) {
                            echo("<option value='{$subdomain['subdomain_id']}'>{$subdomain['is_protected']} - {$subdomain['subdomain_name']}</option>");
                        }
                        ?>
                    </select> <input type="submit" name="submit-button" value="Okay, export now" class="submit"/></td>
            </tr>
        </table>
    </form>
    <p>You will receive the database SQL Scripts in order to export these files.</p>

    <h2>Warning</h2>

    <p>Take a full backup of the source database before you run these scripts.</p>

    <p>If you have completed building a particular subdomain, export it now to a new new database.</p>
</div>
</body>
</html>
