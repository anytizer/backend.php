/** Anti spam measures: revert the values */
document.forms['contact-form'].elements['noemail'].value = "";
document.forms['contact-form'].elements['nospam'].value = 'nospam';

var v = new Validator('contact-form');

v.addValidation('name', 'required', 'Please enter your name.');
v.addValidation('email', 'required', 'Please enter your email address.');
v.addValidation('email', 'email', 'Invalid email address.');
v.addValidation('subject', 'required', 'Type a subject.');
v.addValidation('message', 'required', 'Please type a message.');
v.addValidation('message', 'minlen=20', 'Message should be long enough to be sent as email text.');