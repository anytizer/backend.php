<!--{*
#__DEVELOPER-COMMENTS__

Created on: __TIMESTAMP__
*}-->
<!-- admin details -->
<div class="top-action">
	<ul class="links">
		<!--<li class=""><a href="__ENTITY__-action.php?id={$__ENTITY__.__PK_NAME__}&amp;code={$__ENTITY__.code}" class="">Action</a></li>-->
		<li class="record-add"><a href="__ENTITY__-add.php" class="add">Add __ENTITY_FULLNAME__</a></li>
		<li class="record-list"><a href="__ENTITY__-list.php" class="list">List __ENTITY_FULLNAME__</a></li>
	</ul>
</div>
<div class="clear"></div>
<!-- admin details for administrators -->
<div class="details">
	__DATA_ROWS__
</div>
<div class="clear"></div>
<div class="information">
	<ul class="links admin-editor btm-action">
		<li class="list public">
			<a href="__SINGULAR__.php?id={$__ENTITY__.__PK_NAME__}&amp;code={$__ENTITY__.code}" class="view">As Public</a>
		</li>
		<li class="list edit">
			<a href="__ENTITY__-edit.php?id={$__ENTITY__.__PK_NAME__}&amp;code={$__ENTITY__.code}" class="list">Edit</a>
		</li>
		<li class="list delete">
			<a href="__ENTITY__-delete.php?id={$__ENTITY__.__PK_NAME__}&amp;code={$__ENTITY__.code}" onclick="return window.confirm('Are you sure to delete this?');" class="list">Delete</a>
		</li>
	</ul>
</div>
<div class="clear"></div>
<!-- End of administrators details of __ENTITY__ (__ENTITY_FULLNAME__) -->