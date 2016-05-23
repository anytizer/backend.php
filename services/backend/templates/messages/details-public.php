<!--{*
Created on: 2011-04-06 14:42:31 485
*}-->
<!-- Public details for messages (Messages). {* Remove the fields or entire contents if not. *}-->
<div class="details">
	<div class="holder">
		<div class="title">Message Code</div>
		<div class="content">{$messages.message_code|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Message Status</div>
		<div class="content">{$messages.message_status|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Message Body</div>
		<div class="content">{$messages.message_body|default:'&nbsp;'}</div>
	</div>
</div>
<!-- End of public details of messages (Messages) -->