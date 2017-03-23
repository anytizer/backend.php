/**
 * domains/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): domains ]
 * Example: Confirm before deleting an entity (domains)
 */


/**
 * Select or deselect all visible entities
 * Installs the "check/uncheck all" handler
 */
function _select_deselect_all_visible_domainss() {
    checker = (this.checked == true);
    var lists = document.getElementsByName('domains[]');
    for (var i = 0; i < lists.length; ++i) {
        if (lists[i].type == 'checkbox') {
            lists[i].checked = checker;
        }
    }
    return true;
}
if (document.getElementById('domains-checkall')) {
    document.getElementById('domains-checkall').onclick = _select_deselect_all_visible_domainss;
}


/**
 * Questions and allows to delete an item.
 * Instantly installs the delete handler based on their css class selector
 */
function _confirm_deletion() {
    var success = window.confirm('Are you sure to delete this [ domains ]?');
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
function _blockactions_domains() {
    document.forms['domains-list-form'].elements['action'].value = document.forms['domains-list-form'].elements['actions'].value;

    alert('Performing block action might be dangerous!');
    return false; // remove this line for production
    return true;
}
if (document.forms['domains-list-form']) {
    document.forms['domains-list-form'].onsubmit = _blockactions_domains;
}

handle_ajax_flagging();