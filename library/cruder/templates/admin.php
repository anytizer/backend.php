<!doctype html>
<html>
<head>
	<!--
	Parent Template File (Admin Purpose)
	Produced on: __TIMESTAMP__, __SUBDOMAIN_NAME__
	-->
	<title>Admin - __SUBDOMAIN_NAME__ - {$page.page_title|default:$smarty.const.__FRAMEWORK_NAME__}</title>
	<meta charset="utf-8" />
	<meta name="keywords" content="{$page.meta_keywords|default:$smarty.const.__FRAMEWORK_META_KEYWORDS__}"/>
	<meta name="description" content="{$page.meta_description|default:$smarty.const.__FRAMEWORK_META_DESCRIPTION__}"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="css/management.css" rel="stylesheet" type="text/css"/>
	<script type='text/javascript' src='js/jquery-latest.js'></script>
</head>
<body id="body-admin">
<div class="wrapper">
	<div class="header-wrapper">
		<div class="header">
			<h1 class="header-title"><a href="dashboard.php" title=""><!--project-name--></a></h1>

			<div class="menus-top">
				<p>
					<!-- rather use menu context plugin -->
					<a href="password-change.php">Change Password</a> {loginlink}
				</p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="nav-container">
		<!-- main navigator starts -->
		<div class="navigator-main">
			<ul class="menu nav">
				<li class="current">
					<a href="dashboard.php">Dashboard</a>
					<ul>
						<li><a href="dashboard.php">Home</a></li>
						<li><a href="./" target="website">Website</a></li>
					</ul>
				</li>
				<li>
					<a href="cms-list.php">Setup</a>
					<ul>
						<li><a href="cms-list.php">Content Management</a></li>
						<li><a href="emails-list.php">Email Templates</a></li>
						<li><a href="configurations-list.php">Configurations</a></li>
						<li><a href="identifiers-list.php">Identifiers Lookup</a></li>
						<li><a href="cron.php">Cron Jobs</a></li>
					</ul>
				</li>
				<li>
					<a href="members-list.php">Users</a>
					<ul>
						<li><a href="members-list.php">General Members</a></li>
						<li><a href="administrators-list.php">Administrators</a></li>
					</ul>
				</li>
				<li><a href="reports.php">Reports</a></li>
				{cruded_menus admin=true}
			</ul>
			<div class="clear"></div>
		</div>
		<!-- main navigator ends -->
	</div>
	<div class="content-wrapper">
		<div class="content-panel">
			<div class="content-box">
				<div class="contents">
					<h2 class="content-title">{$page.content_title}</h2>

					<div class="system-message">
						{$page.content_text}
					</div>
					<!-- if the messenger has something to relay -->
					<div id="messenger-holder">{messenger}</div>
					<div class="additional">
						{if $page.include_file|valid_template}                            <!-- main text contents -->                            {include file=$page.include_file} {/if}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="footer">
		<p class="copy-right">
			Copyright &copy; {#COPYRIGHT_SINCE#} - {'Y'|date}, <a
				href="http://__SUBDOMAIN_NAME__/">__SUBDOMAIN_NAME__</a>. All rights reserved.
			<!--
			Powered by <a
			href="{$smarty.const.__DEVELOPER_URL__}">{$smarty.const.__DEVELOPER_NAME__}</a>.
			-->
		</p>
		<!--
				<p class="copy-right" style="color:#FFFF00">
					<strong>Warning</strong>: The live site is under extreme TESTING PHASE. DO NOT WRITE ANY DATA CONTENTS HERE.
				</p>
		-->
	</div>
</div>
<script type='text/javascript' src='js/theme02/menus-dropdown.js'></script>
</body>
</html>
