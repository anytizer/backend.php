/**
 * Populates __ENTITY__ add form.
 */
function __(what, value)
{
	if(!what || !value) return false;

	if(document.forms['__ENTITY__-add-form'].elements['__ENTITY__[' + what + ']'])
	{
		document.forms['__ENTITY__-add-form'].elements['__ENTITY__[' + what + ']'].value = value;
	}

	return true;
}

/**
 * Fill up the data
 */
//__('__SINGULAR__name', 'Name');