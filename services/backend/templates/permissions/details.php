<!--{*
Created on: 2011-03-29 23:48:23 316
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul class="links">
		<li><a href="permissions-add.php"><img src="{'add'|icon}" title="Add Entity Permissions"
		                                       alt="Add Entity Permissions"/> Add Entity Permissions</a></li>
		<li><a href="permissions-list.php"><img src="{'table'|icon}" title="List Entity Permissions"
		                                        alt="List Entity Permissions"/> List Entity Permissions</a></li>
	</ul>
</div>
<div class="clear"></div>
<!-- admmin details for permissions -->
<div class="details">
	<div class="holder">
		<div class="title">Full Name</div>
		<div class="content">{$permissions.full_name|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Crud Name</div>
		<div class="content">{$permissions.crud_name|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Table Name</div>
		<div class="content">{$permissions.table_name|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Pk Name</div>
		<div class="content">{$permissions.pk_name|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Written To</div>
		<div class="content">{$permissions.written_to|default:'&nbsp;'}</div>
	</div>
</div>
<div class="clear"></div>
<div class="information">
	<ul class="links admin-editor">
		<li><a href="permissions-edit.php?id={$permissions.crud_id}&amp;code={$permissions.code}"><img
					src="{'edit'|icon}" title="Edit permissions" alt="Edit permissions"/> Edit this record</a></li>
	</ul>
</div>
<div class="clear"></div>
<!-- End of admin details of permissions (Entity Permissions) -->