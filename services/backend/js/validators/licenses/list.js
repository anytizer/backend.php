/**
 * licenses/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): licenses ]
 * Example: Confirm before deleting an entity (licenses)
 */


/**
 * Select or deselect all visible entities
 * Installs the "check/uncheck all" handler
 */
function _select_deselect_all_visible_licensess() {
    checker = (this.checked == true);
    var lists = document.getElementsByName('licenses[]');
    for (var i = 0; i < lists.length; ++i) {
        if (lists[i].type == 'checkbox') {
            lists[i].checked = checker;
        }
    }
    return true;
}
if (document.getElementById('licenses-checkall')) {
    document.getElementById('licenses-checkall').onclick = _select_deselect_all_visible_licensess;
}


/**
 * Questions and allows to delete an item.
 * Instantly installs the delete handler based on their css class selector
 */
function _confirm_deletion() {
    var success = window.confirm('Are you sure to delete this [ licenses ]?');
    return success;
}
var entries = document.getElementsByTagName("a");
for (var i = 0; i < entries.length; ++i) {
    if (entries[i].className == "delete") {
        entries[i].onclick = _confirm_deletion;
    }
}


/**
 * Confirms a block action before performing it
 */
function _blockactions_licenses() {
    document.forms['licenses-list-form'].elements['action'].value = document.forms['licenses-list-form'].elements['actions'].value;

    alert('Performing block action might be dangerous!');
    return false; // remove this line for production
    return true;
}
if (document.forms['licenses-list-form']) {
    document.forms['licenses-list-form'].onsubmit = _blockactions_licenses;
}

handle_ajax_flagging();