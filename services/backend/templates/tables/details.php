<!-- Created on: 2010-06-11 02:19:25 152 -->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul>
		<li><a href="tables-add.php"><img src="{'add'|icon}"/> Add tables</a></li>
		<li><a href="tables-list.php"><img src="{'table'|icon}"/> List tables</a></li>
	</ul>
</div>
<!-- admmin details for tables -->
<div class="details">
	<div><strong>table_id</strong>: {$tables.table_id}</div>
	<div><strong>sink_weight</strong>: {$tables.sink_weight}</div>
	<div><strong>is_active</strong>: {$tables.is_active}</div>
	<div><strong>table_name</strong>: {$tables.table_name}</div>
	<div><strong>table_comments</strong>: {$tables.table_comments}</div>
	<div><strong>export_structure</strong>: {$tables.export_structure}</div>
	<div><strong>export_data</strong>: {$tables.export_data}</div>
	<div><strong>export_query</strong>: {$tables.export_query}</div>
</div>
<!-- End of tables Details (Admin) -->