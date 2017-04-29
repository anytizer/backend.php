/**
 * When adding a page name to a subdomain, it hints to the administrator, if the page exists already.
 */
function subdomain_page_valid() {
    var page_name = document.forms['page-add-form'].elements['page[page_name]'].value;
    var subdomain = parseInt(document.forms['page-add-form'].elements['page[subdomain_id]'].value);

    if (page_name && subdomain) {
        var ajaxURL = 'ajax-page-valid.php?subdomain_id=' + subdomain + '&page_name=' + page_name + '&rand=' + Math.random();
        ajaxLoader(document.getElementById('page-valid-message'), ajaxURL);
    }
    return (false);
}
document.forms['page-add-form'].elements['page[page_name]'].onblur = subdomain_page_valid;


/**
 * Continue to validate the other fields
 */
var v = new Validator('page-add-form');
v.addValidation('page[subdomain_id]', 'required', 'Please choose a subdomain name.');
v.addValidation('page[page_name]', 'required', 'Please enter a page name.');
v.addValidation('page[page_name]', "regexp=^[a-z0-9\\\_\\\-\\\.]+$", 'Invalid characters in page (file) name.');
v.addValidation('page[page_title]', 'required', 'Please enter page title.');
v.addValidation('page[meta_keywords]', 'required', 'Please enter meta key words separated by a comma ( , ).');
v.addValidation('page[meta_description]', 'required', 'Please type a sentence to describe why this page is used for.');
v.addValidation('page[content_title]', 'required', 'Please type the content heading.\r\nController only pages too should have some identifying title.');
v.addValidation('page[content_text]', 'required', 'Please type page contents.\r\nController only pages too should have some identifying description.');