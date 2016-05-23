var v = new Validator('smtp-edit-form');

/**
 * Agreement
 */
function agreement()
{
	var success = false;
	var yn = document.forms['smtp-edit-form'].elements['smtp[authenticate]'].value;
	if(yn != 'Y' && yn != 'N')
	{
		alert('Authentication flag is only from [ Y / N ]');
		success = false;
	}

	return success;
}
v.setAddnlValidationFunction('agreement');

v.addValidation('smtp[smtp_host]', 'required', 'Please enter a host address to connect to.');
v.addValidation('smtp[smtp_port]', 'required', 'Please enter port SMTP number.');
v.addValidation('smtp[smtp_port]', 'num', 'Port number should be numeric.');
v.addValidation('smtp[do_authenticate]', 'required', 'Please mention whether authenticaion is necessary.');
v.addValidation('smtp[smtp_username]', 'required', 'Please type a username to login as.');
v.addValidation('smtp[smtp_password]', 'required', 'Please type user password to login.');
v.addValidation('smtp[from_name]', 'required', 'Please give the name of FROM name.');
v.addValidation('smtp[from_email]', 'required', 'Please give the primarily depicted email address.');
v.addValidation('smtp[from_email]', 'email', 'Type valid email address.');
v.addValidation('smtp[replyto_name]', 'required', 'Please give the name of REPLYTO name.');
v.addValidation('smtp[replyto_email]', 'required', 'Please give the REPLYTO email address.');
v.addValidation('smtp[replyto_email]', 'email', 'Type valid email address.');
v.addValidation('smtp[smtp_comments]', 'required', 'Please describe this SMTP account.');

/**
 * Click on Yes/No button handler
 */
function click_put(who, where, what)
{
	document.getElementById(who).onclick = function()
	{
		document.getElementById(where).value = what;
	};
}
click_put('put-Y', 'smtp-do_authenticate', 'Y');
click_put('put-N', 'smtp-do_authenticate', 'N');