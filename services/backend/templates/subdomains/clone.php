<style type="text/css">
    <!--
    .sqls-holder {
        margin: 0px 40px 0px 40px;
        background-color: #FFFFCC;
        font-size: 12px;
        font-family: Tahoma, Geneva, sans-serif;
        line-height: 20px;
    }

    .sql-line {
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
<p>Possible errors in: cloning email names (as they are defined unique and hard coded) - query_emalls_smtp</p>
<!--<h1>Clone SQLs</h1>-->
<div class="sqls-holder">
    {section name='c' loop=$clone}
    <div class="sql-line">{$clone[c]}</div>
    {/section}
</div>