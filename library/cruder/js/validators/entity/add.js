// Validate ADD form - __ENTITY__
var v = new Validator('__ENTITY__-add-form');
v.EnableMsgsTogether();

__JAVASCRIPT_ADD_FIELDS__;

/**
 * Extra validations - like Agreement
 */
function agreement()
{
	var success = false;
	// checked
	success = true;

	return success;
}
//v.setAddnlValidationFunction(agreement);

// If jQuery validator is used
// $(document).ready(function(){ $("#__ENTITY__-add-form").validate(); });

document.forms['__ENTITY__-add-form'].elements[0].focus();