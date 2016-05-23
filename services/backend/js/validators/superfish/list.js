/**
 * superfish/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): superfish ]
 * Example: Confirm before deleting an entity (superfish)
 */


/**
 * Select or deselect all visible entities
 * Installs the "check/uncheck all" handler
 */
function _select_deselect_all_visible_superfishs()
{
	checker = (this.checked == true);
	var lists = document.getElementsByName('superfish[]');
	for(var i = 0; i < lists.length; ++i)
	{
		if(lists[i].type == 'checkbox')
		{
			lists[i].checked = checker;
		}
	}
	return true;
}
if(document.getElementById('superfish-checkall'))
{
	document.getElementById('superfish-checkall').onclick = _select_deselect_all_visible_superfishs;
}


/**
 * Questions and allows to delete an item.
 * Instantly installs the delete handler based on their css class selector
 */
function _confirm_deletion()
{
	var success = window.confirm('Are you sure to delete this [ superfish ]?');
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
function _blockactions_superfish()
{
	//alert('Performing the action!');
	document.forms['superfish-list-form'].elements['action'].value = document.forms['superfish-list-form'].elements['actions'].value;
	return true;
}
if(document.forms['superfish-list-form'])
{
	document.forms['superfish-list-form'].onsubmit = _blockactions_superfish;
}

handle_ajax_flagging();