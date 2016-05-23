<table class="data">
	<thead>
	<tr>
		<th>&nbsp;</th>
		<th>Entity</th>
		<th>Operation</th>
		<th>Comments</th>
	</tr>
	</thead>
	<tbody>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>Whole databases</td>
		<td><a href="mysql-backup-databases.php">Backup Scripts</a> (Scripts)</td>
		<td>As accessible by the current user</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>Selected Tables</td>
		<td><a href="mysql-table-import.php">Import Tables</a> (Scripts)</td>
		<td>Helps to import tables from other databases</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>All Tables</td>
		<td><a href="mysql-tables-utf-8.php">Convert to UTF-8</a> (Scripts)</td>
		<td>All tables within this application</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>All Tables</td>
		<td><a href="mysql-backup-tables.php">Backup Scripts</a> (Scripts)</td>
		<td>All tables within this application</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>All Tables</td>
		<td><a href="mysql-restore-tables.php">Restore Scripts</a> (Scripts)</td>
		<td>Produces SQL to restore them</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>*</td>
		<td>All Tables</td>
		<td><a href="mysql-storage-engine.php?engine=InnoDB">Convert to InnoDB</a> (Scripts)</td>
		<td>All tables within this application</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>*</td>
		<td>All Tables</td>
		<td><a href="mysql-storage-engine.php?engine=MyISAM">Convert to MyISAM</a> (Scripts)</td>
		<td>All tables within this application</td>
	</tr>
	<tr class="{cycle values='A,B'}" style="background-color:#FFFF00;">
		<td>&nbsp;</td>
		<td>Framework Tables</td>
		<td><a href="mysql-table-structures.php">Export Table Structures</a></td>
		<td>Exports tables used within this framework, <strong>to the SVN Installer</strong></td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>Clone Views</td>
		<td><a href="mysql-clone-views.php">Create clone views</a></td>
		<td>Generates scripts to clone views</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>Framework Tables</td>
		<td><a href="tables-list.php">Exportable Tables</a> (Admin)</td>
		<td>Administer the list of mysql tables to export</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>Framework Tables</td>
		<td><a href="mysql-backup-framework-tables.php">All tables and data</a> (Scripts)</td>
		<td>Exports <strong>administrative purpose</strong> backup of the framework tables</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>By Prefix Group</td>
		<td><a href="mysql-backup-by-group.php">Backup by prefix</a> (Scripts)</td>
		<td>Group tables by their prefixes and backup as a single dump.</td>
	</tr>
	<tr class="{cycle values='A,B'}">
		<td>&nbsp;</td>
		<td>To MSSQL</td>
		<td><a href="mysql-to-mssql.php">Export to MSSQL</a></td>
		<td>Convert the data to MSSQL compatible dump files.</td>
	</tr>
	</tbody>
</table>
<p><strong>Notes:</strong></p>
<ol start="1">
	<li>* Risky Operation.</li>
	<li>Clicking on the link will produce Terminal Commands or SQL only. It won't affect the real system immediately.</li>
	<li>Converting into MyISAM will lose support to foreign keys.</li>
	<li>Conveting into InnoDB will lose support to FULLTEXT KEY.</li>
</ol>