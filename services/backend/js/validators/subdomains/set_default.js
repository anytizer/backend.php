/**
 * <a> tag handler
 * while adding/editing subdomains
 */
function set_default(element_name, default_value)
{
	document.forms['subdomains-form'].elements[element_name].value = default_value;
	return(false);
}
