<!-- This page is for an example only -->
<!-- paginator -->
<div class="paginator" style="padding-bottom:10px; padding-top:10px;">
    Jump to: {paginate separator = ' ' ulli=false source=$pagination}
</div>
<!-- contents -->
<div class="pages">
    {section name='p' loop=$pages}
    <div><strong>{$pages[p].name}</strong>: {$pages[p].title}</div>
    {/section}
</div>
<!-- paginator -->
<div class="paginator" style="padding-bottom:10px; padding-top:10px;">
    Jump to: {paginate separator = ' ' ulli=false source=$pagination}
</div>
{*
<!-- ulli -->
<div class="paginator">
    <ul>{paginate page='./' ulli=true source=$pagination}</ul>
</div>
*}