/**
 * emails/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): emails ]
 * Example: Confirm before deleting an entity (emails)
 */


/**
 * Select or deselect all visible entities
 * Installs the "check/uncheck all" handler
 */
function _select_deselect_all_visible_emailss()
{
	checker = (this.checked == true);
	var lists = document.getElementsByName('emails[]');
	for(var i = 0; i < lists.length; ++i)
	{
		if(lists[i].type == 'checkbox')
		{
			lists[i].checked = checker;
		}
	}
	return true;
}
if(document.getElementById('emails-checkall'))
{
	document.getElementById('emails-checkall').onclick = _select_deselect_all_visible_emailss;
}


/**
 * Questions and allows to delete an item.
 * Instantly installs the delete handler based on their css class selector
 */
function _confirm_deletion()
{
	var success = window.confirm('Are you sure to delete this [ emails ]?');
	return success;
}
var entries = document.getElementsByTagName('a');
for(var i = 0; i < entries.length; ++i)
{
	if(entries[i].className == 'delete')
	{
		entries[i].onclick = _confirm_deletion;
	}
}


/**
 * Confirms a block action before performing it
 */
function _blockactions_emails()
{
	document.forms['emails-list-form'].elements['action'].value = document.forms['emails-list-form'].elements['actions'].value;

	alert('Performing block action might be dangerous!');
	return false; // remove this line for production
	return true;
}
if(document.forms['emails-list-form'])
{
	document.forms['emails-list-form'].onsubmit = _blockactions_emails;
}

handle_ajax_flagging();