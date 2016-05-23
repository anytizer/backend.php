<!-- Created on: 2010-12-04 02:20:11 635 -->
<!-- Public details for tables. {* Remove the fields or entire contents if not. *}-->
<div class="details">
	<div class="holder">
		<div class="title">Export Structure</div>
		<div class="content">{$tables.export_structure|yn} {$tables.export_structure|yesno}</div>
	</div>
	<div class="holder">
		<div class="title">Export Data</div>
		<div class="content">{$tables.export_data|tick} {$tables.export_data|yesno}</div>
	</div>
	<div class="holder">
		<div class="title">Table Name</div>
		<div class="content">{$tables.table_name}</div>
	</div>
	<div class="holder">
		<div class="title">Table Comments</div>
		<div class="content">{$tables.table_comments|default:'N/A'}</div>
	</div>
	<div class="holder">
		<div class="title">Export Comments</div>
		<div class="content">{$tables.export_comments|default:'N/A'}</div>
	</div>
	<div class="holder">
		<div class="title">Export Query</div>
		<div class="content">
			<pre>{$tables.export_query|default:'Not used yet. May be the control flags are enough for exporting this table.'}</pre>
		</div>
	</div>
</div>
<!-- End of tables Details (Public) -->