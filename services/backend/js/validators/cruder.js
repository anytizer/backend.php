// Validates the CRUDer user input parameters

var v = new Validator('cruder-form');
v.EnableMsgsTogether();

// Subdomain ID
v.addValidation('entity[subdomain_id]', 'required', 'Choose a subdomain to CRUD this entity.');

// Entity name
v.addValidation('entity[name]', 'required', 'Enter an entity name to CRUD.');

// Reverse typed name as a self CAPTCHA for admin purpose
v.addValidation('entity[reverse]', 'required', 'Enter the entity name in reversed letters.');

// Table name
v.addValidation('entity[table_name]', 'required', 'What is the MySQL table name for this entity?');

// PRIMARY KEY
v.addValidation('entity[pk_name]', 'required', 'What is the name of PRIMARY KEY in this entity?');

/**
 * entity and revesed name should match
 */
function reversed_entity_check()
{
	var original = document.forms['cruder-form'].elements['entity[name]'].value;
	var reversed = document.forms['cruder-form'].elements['entity[reverse]'].value;

	var success = (original != "" && reversed != "" && original.split("").reverse().join("") == reversed);
	if(success != true)
	{
		alert("Self CAPTCHA Error:\r\nYour entity name and reversed letters mismatched.");
	}

	return success;
}
v.setAddnlValidationFunction('reversed_entity_check');

function reverse_captcha()
{
	var original = document.forms['cruder-form'].elements['entity[name]'].value;
	var reversed = original.split("").reverse().join("");
	//document.getElementById('reverse-captcha').innerHTML = reversed;
	document.getElementById('reverse-captcha').value = reversed;
	return true;
}
document.getElementById('entity-name').onkeyup = reverse_captcha;

document.forms['cruder-form'].elements['entity[pk_name]'].value = '_id';
document.forms['cruder-form'].elements['entity[__ENTITY_FULLNAME__]'].focus();