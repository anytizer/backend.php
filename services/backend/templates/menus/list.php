<!-- Created on: 2009-11-11 20:01:53 711 -->
<div class="information">
    <ul>
        <li><a href="menus-contexts.php">Contexts and Sorter</a></li>
        <li>|</li>
        <li><a href="menus-add.php">Add a menu</a></li>
    </ul>
</div>
<table class="data">
    <thead>
    <tr>
        <th>S.N.</th>
        <th>Delete</th>
        <th>Context</th>
        <th>Menu Text / Link</th>
        <th>Class</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    {section name='l' loop=$menuss}
    <tr class="{cycle values='A,B'}">
        <td class="r">{$smarty.section.l.index_next}.</td>
        <td><a class="delete"
               href="menus-delete.php?id={$menuss[l].menu_id}&amp;code={$menuss[l].code}">{icon name='delete'}</a></td>
        <td>{$menuss[l].menu_context}</td>
        <td><a href="{$menuss[l].menu_link}">{$menuss[l].menu_text}</a></td>
        <td>{$menuss[l].html_class}</td>
        <td>
            <a class="refresh"
               href="menus-sort.php?id={$menuss[l].menu_id}&code={$menuss[l].code}&context={$menuss[l].menu_context|urlencode}">{icon
                name='refresh'}</a>
            <a class="edit" href="menus-edit.php?id={$menuss[l].menu_id}&code={$menuss[l].code}">{icon name='edit'}</a>
        </td>
    </tr>
    {sectionelse}
    <tr>
        <td>-</td>
        <td>&nbsp;</td>
        <td>-</td>
        <td>-</td>
        <td>&nbsp;</td>
        <td>-</td>
    </tr>
    {/section}
    </tbody>
</table>
{* Handlers, Ajax, Validators *}
{js src='validators/menus/list.js' validator=true}