<!--{*
Created on: 2011-02-14 12:48:48 850
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul class="links">
		<li><a href="domains-add.php"><img src="{'add'|icon}" title="Add Domains" alt="Add Domains"/> Add Domains</a>
		</li>
		<li><a href="domains-list.php"><img src="{'table'|icon}" title="List Domains" alt="List Domains"/> List Domains</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- admmin details for domains -->
<div class="details">
	<div class="holder">
		<div class="title">Check After</div>
		<div class="content">{$domains.check_after|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Response Code</div>
		<div class="content">{$domains.response_code|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Modified On</div>
		<div class="content">{$domains.modified_on|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Domain Name</div>
		<div class="content">{$domains.domain_name|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">URL Local</div>
		<div class="content">{$domains.url_local|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">URL Live</div>
		<div class="content">{$domains.url_live|default:'&nbsp;'}</div>
	</div>
</div>
<div class="clear"></div>
<div class="information">
	<ul class="links admin-editor">
		<li><a href="domains-edit.php?id={$domains.domain_id}&amp;code={$domains.code}"><img src="{'edit'|icon}"
		                                                                                     title="Edit domains"
		                                                                                     alt="Edit domains"/> Edit this record</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- End of admin details of domains (Domains) -->