<link href="css/dashboard.css" rel="stylesheet" type="text/css"/>
<div class="dashboard">
	{section name='d' loop=$dashboards}
	<div class="entry" onclick="window.location='{$dashboards[d].link}';">
		<div class="icon dashboard-{$dashboards[d].sprite}"></div>
		<div class="text"><a href="{$dashboards[d].link}">{$dashboards[d].text}</a></div>
	</div>
	{sectionelse}
	<div class="entry">
		<div class="icon"></div>
		<div class="text">Nothing!</div>
	</div>
	{/section}
	<div style="clear:both"></div>
</div>
