<!--{*
Created on: 2011-04-06 14:42:31 485
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul class="links">
		<li><a href="messages-add.php" class="add"><img src="{'add'|icon}" title="Add Messages"
		                                                alt="Add Messages"/> Add Messages</a></li>
		<li><a href="messages-list.php" class="list"><img src="{'table'|icon}" title="List Messages"
		                                                  alt="List Messages"/> List Messages</a></li>
	</ul>
</div>
<div class="clear"></div>
<!-- admmin details for messages -->
<div class="details">
	<div class="holder">
		<div class="title">Implementation</div>
		<div class="content">{chr(123)}messenger code='{$messages.message_code}'{chr(125)}</div>
	</div>
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
<div class="clear"></div>
<h2>Sample</h2>
<div>{messenger code=$messages.message_code}</div>
<div class="information">
	<ul class="links admin-editor">
		<li class="list"><a href="messages-edit.php?id={$messages.message_id}&amp;code={$messages.code}"
		                    class="list"><img src="{'edit'|icon}" title="Edit messages"
		                                      alt="Edit messages"/> Edit this record</a></li>
	</ul>
</div>
<div class="clear"></div>
<!-- End of admin details of messages (Messages) -->