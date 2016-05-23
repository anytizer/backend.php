/**
 * Validates the login form.
 */

/**
 * First, set up the focus.
 */
document.forms['login-form'].elements['username'].focus();

var v = new Validator('login-form');
v.addValidation('username', 'required', 'Please type your username/email');
// Most probably, the usename is an email address.
//v.addValidation('username', 'email', 'Please type your email address (for username) coreectly.');
v.addValidation('password', 'required', 'Please type your password');