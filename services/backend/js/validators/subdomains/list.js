/**
 * subdomains/list.js
 * Unobtrusive JavaScript References:
 *    http://en.wikipedia.org/wiki/Unobtrusive_JavaScript
 *    http://www.onlinetools.org/articles/unobtrusivejavascript/index.html
 * Installs various actions in the list of records [ 27 (backend): subdomains ]
 * Example: Confirm before deleting an entity (subdomains)
 */

/**
 * Live search subdomain names
 */
function livesearch_subdomains()
{
	var str = this.value;
	if(str.length <= 1)
	{
		document.getElementById('livesearch-results').innerHTML = "";
		document.getElementById('livesearch-results').style.border = '0px';
		return false;
	}
	var xmlhttp = getXMLHTTPRequest();

	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById('livesearch-results').innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open('GET', 'subdomains-livesearch.php?q=' + str, true);
	xmlhttp.send();
}
document.forms['subdomains-livesearch'].elements['subdomain_name'].onkeyup = livesearch_subdomains;
document.forms['subdomains-livesearch'].elements['subdomain_name'].focus();


/**
 * Select or deselect all visible entities
 * Installs the "check/uncheck all" handler
 */
function _select_deselect_all_visible_subdomainss()
{
	checker = (this.checked == true);
	var lists = document.getElementsByName('subdomains[]');
	for(var i = 0; i < lists.length; ++i)
	{
		if(lists[i].type == 'checkbox')
		{
			lists[i].checked = checker;
		}
	}
	return true;
}
if(document.getElementById('subdomains-checkall'))
{
	document.getElementById('subdomains-checkall').onclick = _select_deselect_all_visible_subdomainss;
}


/**
 * Questions and allows to delete an item.
 * Instantly installs the delete handler based on their css class selector
 */
function _confirm_deletion()
{
	var success = window.confirm('Are you sure to delete this [ subdomains ]?');
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
function _blockactions_subdomains()
{
	document.forms['subdomains-list-form'].elements['action'].value = document.forms['subdomains-list-form'].elements['actions'].value;

	alert('Performing block action might be dangerous!');
	return false; // remove this line for production
	return true;
}
if(document.forms['subdomains-list-form'])
{
	document.forms['subdomains-list-form'].onsubmit = _blockactions_subdomains;
}

handle_ajax_flagging();