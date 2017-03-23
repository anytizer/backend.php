/**
 * Validates various actions in the list of records [ defines ]
 * defines/list.js
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