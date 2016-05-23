<!--{*
Created on: 2011-02-10 00:12:27 318
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul class="links">
		<li><a href="licenses-add.php"><img src="{'add'|icon}" title="Add License" alt="Add License"/> Add License</a>
		</li>
		<li><a href="licenses-list.php"><img src="{'table'|icon}" title="List License" alt="List License"/> List License</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- admmin details for licenses -->
<div class="details">
	<div class="holder">
		<div class="title">Application Name</div>
		<div class="content">{$licenses.application_name|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Server Name</div>
		<div class="content">{$licenses.server_name|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Protection Key</div>
		<div class="content">{$licenses.protection_key|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">License Key</div>
		<div class="content">{$licenses.license_key|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">License Email</div>
		<div class="content">{$licenses.license_email|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">License To</div>
		<div class="content">{$licenses.license_to|default:'&nbsp;'}</div>
	</div>
</div>
<div class="clear"></div>
<div class="information">
	<ul class="links admin-editor">
		<li><a href="licenses-edit.php?id={$licenses.license_id}&amp;code={$licenses.code}"><img src="{'edit'|icon}"
		                                                                                         title="Edit licenses"
		                                                                                         alt="Edit licenses"/> Edit this record</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- End of admin details of licenses (License) -->