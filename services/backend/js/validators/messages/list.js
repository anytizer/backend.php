/**
 * messages/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): messages ]
 * Example: Confirm before deleting an entity (messages)
 */

/**
 * Live search, if enabled. Requires ajax.js
 */
/**
 function livesearch_messages()
 {
	var str = this.value;
	if (str.length<=1)
	{ 
		document.getElementById('livesearch-results').innerHTML="";
		document.getElementById('livesearch-results').style.border='0px';
		return false;
	}
	var xmlhttp = getXMLHTTPRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById('livesearch-results').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open('GET', 'messages-livesearch.php?q='+str,true);
	xmlhttp.send();
}
 document.forms['messages-livesearch'].elements['search[name]'].onkeyup = livesearch_messages;
 document.forms['messages-livesearch'].elements['search[name]'].focus();
 */

/**
 * Select or deselect all visible entities
 * Installs the "check/uncheck all" handler
 */
function _select_deselect_all_visible_messagess() {
    checker = (this.checked == true);
    var lists = document.getElementsByName('messages[]');
    for (var i = 0; i < lists.length; ++i) {
        if (lists[i].type == 'checkbox') {
            lists[i].checked = checker;
        }
    }
    return true;
}
if (document.getElementById('messages-checkall')) {
    document.getElementById('messages-checkall').onclick = _select_deselect_all_visible_messagess;
}


/**
 * Questions and allows to delete an item.
 * Instantly installs the delete handler based on their css class selector
 */
function _confirm_deletion() {
    var success = window.confirm('Are you sure to delete this [ messages ]?');
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
function _blockactions_messages() {
    document.forms['messages-list-form'].elements['action'].value = document.forms['messages-list-form'].elements['actions'].value;

    alert('Performing block action might be dangerous!');
    return false; // remove this line for production
    return true;
}
if (document.forms['messages-list-form']) {
    document.forms['messages-list-form'].onsubmit = _blockactions_messages;
}

handle_ajax_flagging();