/**
 * subdomains/add.js
 * Validates adding [ 27 (backend): subdomains ]
 * Reference: http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
 */

//var v = new Validator('subdomains-add-form');

/**
 * Agreement
 */
function agreement()
{
	var success = false;
	// checked
	success = true;

	return success;
}
//v.setAddnlValidationFunction('agreement');

document.forms['subdomains-add-form'].elements['subdomains[subdomain_name]'].focus();