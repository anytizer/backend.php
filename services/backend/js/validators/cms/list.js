/**
 * cms/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): cms ]
 * Example: Confirm before deleting an entity (cms)
 */


/**
 * Select or deselect all visible entities
 * Installs the "check/uncheck all" handler
 */
function _select_deselect_all_visible_cmss() {
    checker = (this.checked == true);
    var lists = document.getElementsByName('cms[]');
    for (var i = 0; i < lists.length; ++i) {
        if (lists[i].type == 'checkbox') {
            lists[i].checked = checker;
        }
    }
    return true;
}
if (document.getElementById('cms-checkall')) {
    document.getElementById('cms-checkall').onclick = _select_deselect_all_visible_cmss;
}


/**
 * Questions and allows to delete an item.
 * Instantly installs the delete handler based on their css class selector
 */
function _confirm_deletion() {
    var success = window.confirm('Are you sure to delete this [ cms ]?');
    return success;
}
var entries = document.getElementsByTagName('a');
for (var i = 0; i < entries.length; ++i) {
    if (entries[i].className == 'delete') {
        entries[i].onclick = _confirm_deletion;
    }
}


/**
 * Confirms a block action before performing it
 */
function _blockactions_cms() {
    document.forms['cms-list-form'].elements['action'].value = document.forms['cms-list-form'].elements['actions'].value;

    alert('Performing block action might be dangerous!');
    return false; // remove this line for production
    return true;
}
if (document.forms['cms-list-form']) {
    document.forms['cms-list-form'].onsubmit = _blockactions_cms;
}

handle_ajax_flagging();