<!--{*
Created on: 2011-03-23 11:38:46 911
*}-->
<!-- Public details for emails (Emails). {* Remove the fields or entire contents if not. *}-->
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
<!-- End of public details of emails (Emails) -->