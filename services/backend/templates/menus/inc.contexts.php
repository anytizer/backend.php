<h2>Valid, Menu contexts used so far:</h2>
<p>Click on one of the context below, to use it.</p>
<ul style="list-style:disc; padding-left:30px;">
    {section name='c' loop=$contexts}
    <li>
        <a href="menus-sort.php?context={$contexts[c].menu_context|urlencode}">View/Sort</a> | <span class="copy-text"
                                                                                                     title="{$contexts[c].menu_context|htmlentities}">{$contexts[c].menu_context}</span>
    </li>
    {sectionelse}
    <li>No menu context yet.</li>
    {/section}
</ul>
<p>Contexts are the group of menus. If you add a new menu under a context, it will show up within the same group. If you
    type a new contenxt, a new group will be formed. Contexts may be
    <strong>cAsE sEnSiTiVe</strong>!</p>