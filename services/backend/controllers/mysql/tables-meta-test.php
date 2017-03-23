<?php
/**
 * Specially format the display
 * @todo This file might broken HTML due to source code formatting of PHP without end tags
 */
function fecho($string = "", $match = "", $match_print = "", $default = "")
{
	echo($string ? $string : '&nbsp;');

	return;

	$print = $string;
	if ($match != "" && $string == $match) {
		$print = $match_print;
	} else {
		$print = $default;
	}
	$print = ($print) ? $print : '&nbsp;';
	echo $print;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Field Meta </title>
	<style type="text/css">
		<!--
		body, td, th {
			font-family: Verdana, Arial, Helvetica, sans -serif;
			font-size: 10px;
			color: #000033;
		}

		body {
			background -color: #FFFFFF;
		}

		td, th {
			border-left: 1px solid #DDDDDD;
			border-top: 1px solid #DDDDDD;
			padding: 4px;
		}

		table {
			border: 1px solid #999999;
		}

		.thead {
			background -color: #999999;
			font -weight: bold;
			text -align: left;
		}

		.warning {
			background-color: #FFFF00;
		}

		.error {
			background-color: #FF0000;
		}

		.blob {
			background-color: #0000FF;
		}

		.A {
		}

		.B {
			background-color: #FFCCFF;
		}

		.wrapper {
			width: 1000px;
			margin: 0px auto 0px auto;
		}

		-->
	</style>
</head>

<body>
<div class="wrapper">
	<h2>Tables and Fields Properties </h2>

	<p>This process ist to ensure good database design . It helps to maintain a database easily for longer time . It
		works with the following testing:</p>
	<ol>
		<li>Each column has a NOT null constraint.</li>
		<li>Minimize the use of; BLOB fields.</li>
		<li>Numeric fields are NOT defined as UNSIGNED.</li>
		<li>Primary is is not AUTO_INCREMENT</li>
		<li>UNIQUE KEY is used less.</li>
		<li>The field type contains uncommon Data Type.</li>
		<li>Column name does not contain a prefix or begins with an underscore.</li>
		<li>Table name begins with non alphabetic character.</li>
		<li>Table name is NOT in lowercase.</li>
		<li>DATETIME is used instead of a unix timestamp INTEGER.</li>
	</ol>
	<p>To DO:</p>
	<ol>
		<li>Column comment is empty.</li>
		<li>Table comment is empty.</li>
		<li>Primary key if integer, is not of size 10.</li>
		<li>VARBINARY is used.</li>
		<li>REAL's size is not 8,2.</li>
		<li>Warn Composite Key, not errors due to AUTO_INCREMENT.</li>
	</ol>
	<table border="0" cellspacing="0">
		<tr class="thead">
			<th>Table</th>
			<th>Name</th>
			<th>Default</th>
			<th>Max Length</th>
			<th>Not Null</th>
			<th>Primary Key</th>
			<th>Unique Key</th>
			<th>Multiple Key</th>
			<th>Numeric</th>
			<th>Blob</th>
			<th>Type</th>
			<th>Unsigned</th>
			<th>Zerofill</th>
		</tr>
		<?php
		$sql = "SHOW TABLES;";
		$table_result = mysql_query($sql); # @todo Change to MySQLi

		$table = "";
		$j = 0;
		while ($row = mysql_fetch_row($table_result)) { # @todo Change to MySQLi
			$table = $row[0];

			$result = mysql_query("SELECT * FROM `{$table}` LIMIT 1;"); # @todo Change to MySQLi
			#if(!mysql_num_rows($result))
			#	continue;

			$i = 0;
			while ($i < mysql_num_fields($result)) { # @todo Change to MySQLi
				$meta = mysql_fetch_field($result, $i); # @todo Change to MySQLi
				$flags = mysql_field_flags($result, $i); # @todo Change to MySQLi

				?>
				<tr class="<?php echo((++$j % 2) ? 'A' : 'B'); ?>">
					<td class="<?php echo (preg_match(' /^[^a - z]/', $meta->table) || strtolower($meta->table) != $meta->table) ? 'warning' : ""; ?>"><?php fecho($meta->table); ?></td>
					<td class="<?php echo !preg_match(' /^[^\_].*?\_ / ', $meta->name) ? 'warning' : ""; ?>"><?php fecho($meta->name); ?></td>
					<td><?php fecho($meta->def); ?></td>
					<td><?php fecho($meta->max_length); ?></td>
					<td class="<?php echo ($meta->not_null == 1) ? "" : 'error'; ?>"><?php fecho($meta->not_null, '1', "", 'N'); ?></td>
					<td class="<?php echo ($meta->primary_key == 1 && !preg_match(' / auto_increment / ', $flags)) ? 'error' : ""; ?>"><?php fecho($meta->primary_key); ?></td>
					<td class="<?php echo ($meta->unique_key == 1) ? 'warning' : ""; ?>"><?php fecho($meta->unique_key); ?></td>
					<td><?php fecho($meta->multiple_key); ?></td>
					<td><?php fecho($meta->numeric); ?></td>
					<td class="<?php echo ($meta->blob != 1) ? "" : 'blob'; ?>"><?php fecho($meta->blob); ?></td>
					<td class="<?php echo (!in_array($meta->type, array('string', 'int', 'real', 'blob', 'date'))) ? 'warning' : ""; ?>"><?php fecho($meta->type); ?></td>
					<td class="<?php echo ($meta->numeric == 1 && $meta->unsigned != 1) ? 'error' : ""; ?>"><?php fecho($meta->unsigned, '1', 'Y', ""); ?></td>
					<td><?php fecho($meta->zerofill, '1', "", 'N'); ?></td>
				</tr>
				<?php
				$i++;
			}
		}
		?>
	</table>
</div>
</body>
</html>
