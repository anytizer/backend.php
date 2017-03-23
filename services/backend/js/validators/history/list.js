/**
 * history/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): history ]
 * Example: Confirm before deleting an entity (history)
 */

/**
 * Questions and allows to delete an item.
 */
function confirm_deletion() {
    var success = window.confirm('Are you sure to delete this item?');
    return success;
}

/**
 * Installs the delete handler
 */
var entries = document.getElementsByTagName('a');
for (var i = 0; i < entries.length; ++i) {
    if (entries[i].className == 'delete') {
        entries[i].onclick = confirm_deletion;
    }
}

handle_ajax_flagging();