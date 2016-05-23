<!--{*
Created on: 2011-03-23 11:38:46 911
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul class="links">
		<li><a href="emails-add.php"><img src="{'add'|icon}" title="Add Emails" alt="Add Emails"/> Add Emails</a></li>
		<li><a href="emails-list.php"><img src="{'table'|icon}" title="List Emails" alt="List Emails"/> List Emails</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- admmin details for emails -->
<div class="details">
	<div class="holder">
		<div class="title">Language</div>
		<div class="content">{$emails.language|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Email Code</div>
		<div class="content">{$emails.email_code|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Email Subject</div>
		<div class="content">{$emails.email_subject|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Email HTML</div>
		<div class="content">{$emails.email_html|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Email Text</div>
		<div class="content">{$emails.email_text|pre}</div>
	</div>
</div>
<div class="clear"></div>
<div class="information">
	<ul class="links admin-editor">
		<li><a href="emails-edit.php?id={$emails.email_id}&amp;code={$emails.code}"><img src="{'edit'|icon}"
		                                                                                 title="Edit emails"
		                                                                                 alt="Edit emails"/> Edit this record</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- End of admin details of emails (Emails) -->