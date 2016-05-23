<!--{*
Created on: 2011-03-29 23:48:23 316
*}-->
<!-- Public details for permissions (Entity Permissions). {* Remove the fields or entire contents if not. *}-->
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
<!-- End of public details of permissions (Entity Permissions) -->