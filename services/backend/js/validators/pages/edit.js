/**
 * Only few fields are loaded while editing a page.
 * Few others are optional.
 */
var v = new Validator('page-editor-form');
v.addValidation('page[page_title]', 'required', 'Please enter page title.');
v.addValidation('page[meta_keywords]', 'required', 'Please enter meta key words separated by a comma ( , ).');
v.addValidation('page[meta_description]', 'required', 'Please type a sentence to describe why this page is used for.');
v.addValidation('page[content_title]', 'required', 'Please type the content heading.\r\nController only pages too should have some identifying title.');
v.addValidation('page[content_text]', 'required', 'Please type page contents.\r\nController only pages too should have some identifying description.');