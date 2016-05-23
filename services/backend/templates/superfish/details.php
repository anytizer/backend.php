<!--{*
Created on: 2011-02-02 00:36:55 983
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul class="links">
		<li><a href="superfish-add.php"><img src="{'add'|icon}" title="Add Menus" alt="Add Menus"/> Add Menus</a></li>
		<li><a href="superfish-list.php"><img src="{'table'|icon}" title="List Menus" alt="List Menus"/> List Menus</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- admmin details for superfish -->
<div class="details">
	<div class="holder">
		<div class="title">Context</div>
		<div class="content">{$superfish.context|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Menu Text</div>
		<div class="content">{$superfish.menu_text|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Menu Link</div>
		<div class="content">{$superfish.menu_link|default:'&nbsp;'}</div>
	</div>
</div>
<div class="clear"></div>
<div class="information">
	<ul class="links admin-editor">
		<li><a href="superfish-edit.php?id={$superfish.menu_id}&amp;code={$superfish.code}"><img src="{'edit'|icon}"
		                                                                                         title="Edit superfish"
		                                                                                         alt="Edit superfish"/> Edit this record</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- End of admin details of superfish (Menus) -->