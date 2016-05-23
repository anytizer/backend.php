<p>
	{if $smarty.session.user_id} <a href="./">Home</a> | {if $smarty.session.is_admin} <a
		href="categories-list.php">Categories</a> | <a href="posts-list.php">Posts</a> | <a
		href="users-list.php">Users</a> | {else} <a href="posts.php">Posts</a> | {/if} <a
		href="logout.php">Logout</a> {else} <a href="login.php">Login</a> {/if}
</p>