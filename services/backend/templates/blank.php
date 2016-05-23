{if $page.include_file|valid_template}
{include file=$page.include_file}
{else}
<p>Include file NOT defined. Attempted loading a blank template.</p>
{/if}