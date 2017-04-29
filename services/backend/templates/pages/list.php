<link href="css/admin.css" rel="stylesheet" type="text/css"/>
<h2>Important notices:</h2>
<ul style="margin-left:20px; margin-bottom:20px;">
    <li>Click on the page name to edit it and the related contents.</li>
    <li>Please add a page manually, from the database (For safety, that a new page does not require that facility).</li>
    <li>Please use <a href="cruder.php">CRUDer service</a> if you need fully featured add/delete/list of an entity.</li>
</ul>
<form name="subdomains-pages" method="post" action="?">
    Choose a specific subdomain: <select name="subdomain_id">
        <option value="">-- choose a subdomain --</option>
        {html_options options='system:services'|dropdown selected='subdomain_id'|magical} </select> <input type="submit"
                                                                                                           name="submit-buttom"
                                                                                                           value="List pages"
                                                                                                           class="submit"/>
</form>
<div class="information" style="margin-top:10px;">
    <ul>
        <li><a href="pages-statistics.php">Statistics</a></li>
        <li>{icon name='add'} <a href="pages-add.php">Add a page</a></li>
        <li>{icon name='list'} <a href="pages-sort.php">Sort pages</a></li>
    </ul>
</div>
<p>?: <strong class="error">1#</strong> Delete <strong class="error">2#</strong> Edit <strong
        class="error">3#</strong> List <strong class="error">4#</strong> Admin only <strong
        class="error">5#</strong> Reset login requirement.</p>
<div class="pages">
    <div class="page-holder header">
        <div class="icon">?</div>
        <div class="page"><a href="?sort=page">Page</a></div>
        <div class="title"><a href="?sort=title">Title</a></div>
    </div>
    {section name='p' loop=$pages}
    <div class="page-holder {cycle values='A,B'}">
        <div class="icon">
            <a href="pages-delete.php?pi={$pages[p].i}"><img src="images/blank.png" alt="delete" title="Remove"
                                                             class="icon-delete"/></a> <a
                href="pages-edit.php?pi={$pages[p].i}"><img src="images/blank.png" alt="delete" title="Remove"
                                                            class="icon-edit"/></a> <a
                href="{$pages[p].n}">{icon name='list'}</a> {$pages[p].ia|tick:$pages[p].i:'icon-admin'}
            {$pages[p].nl|tick:$pages[p].i:'icon-login'}
        </div>
        <div class="page"><a href="pages-edit.php?pi={$pages[p].i}">{$pages[p].n|default:'__N/A__'}</a></div>
        <div class="title">{$pages[p].t|default:'__N/A__'}</div>
    </div>
    {sectionelse}
    <div class="page-holder">
        <div class="icon">*</div>
        <div class="page {cycle values='A,B'}">No active pages to list out.</div>
        <div class="title">-</div>
    </div>
    {/section}
</div>
<div class="marginal"><a name="bottom">
        <!--{* browses here once a page is removed... redirected to #bottom, by the deletion *}-->
    </a></div>
{js src='validators/pages/list.js'}