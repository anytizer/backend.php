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
<div class="sqls-holder">
	{section name='s' loop=$sqls}
	<div class="sql-line">{$sqls[s]}</div>
	{/section}
</div>