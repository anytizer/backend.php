/**
 * identifiers/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): identifiers ]
 * Example: Confirm before deleting an entity (identifiers)
 */


/**
 * Select or deselect all visible entities
 * Installs the "check/uncheck all" handler
 */
function _select_deselect_all_visible_identifierss() {
    checker = (this.checked == true);
    var lists = document.getElementsByName('identifiers[]');
    for (var i = 0; i < lists.length; ++i) {
        if (lists[i].type == 'checkbox') {
            lists[i].checked = checker;
        }
    }
    return true;
}
if (document.getElementById('identifiers-checkall')) {
    document.getElementById('identifiers-checkall').onclick = _select_deselect_all_visible_identifierss;
}


/**
 * Questions and allows to delete an item.
 * Instantly installs the delete handler based on their css class selector
 */
function _confirm_deletion() {
    var success = window.confirm('Are you sure to delete this [ identifiers ]?');
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
function _blockactions_identifiers() {
    document.forms['identifiers-list-form'].elements['action'].value = document.forms['identifiers-list-form'].elements['actions'].value;

    alert('Performing block action might be dangerous!');
    return false; // remove this line for production
    return true;
}
if (document.forms['identifiers-list-form']) {
    document.forms['identifiers-list-form'].onsubmit = _blockactions_identifiers;
}

handle_ajax_flagging();