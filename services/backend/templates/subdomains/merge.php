<style type="text/css">
	<!--
	.sqls-holder
	{
		margin: 0px 40px 0px 40px;
		background-color: #FFFFCC;
	}

	.sql-line
	{
		padding: 5px 0px 5px 10px;
		border-bottom: 1px solid #0099FF;
	}

	-->
</style>
<!--{*
<h1>Update SQLs</h1>
<div class="sqls-holder">
{section name='u' loop=$update}
	<div class="sql-line">{$update[u]}</div>
{/section}
</div>
*}-->
<p>Possible errors in: meging - email names (as they are defined unique and hard coded) -
	<strong>query_emalls_smtp</strong>,
	<strong>query_menus</strong> might have IDs dependent and you may have to remake this.</p>
<!--<h1>Clone SQLs</h1>-->
<div class="sqls-holder" style="font-size:12px; font-family:Tahoma, Geneva, sans-serif; line-height:20px;">
	{section name='m' loop=$merge}
	<div class="sql-line">{$merge[m]}</div>
	{/section}
</div>