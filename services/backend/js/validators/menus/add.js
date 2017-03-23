/**
 * Validates adding [ menus ]
 * menus/list.js
 */

var v = new Validator('menus-add-form');
v.addValidation('menus[menu_context]', 'req', 'Type menu context');
v.addValidation('menus[menu_text]', 'req', 'Type menu text as seen when printed.');
v.addValidation('menus[menu_link]', 'req', 'Give relative/absolute link to jump to');

/**
 * Agreement
 */
function correct_data_agreement() {
    var success = window.confirm('Are you sure all data is correct?');
    return success;
}
v.setAddnlValidationFunction('correct_data_agreement');

/**
 * Hint the menu texts
 */
function load_menu_status() {
    var url = 'ajax-menus.php?context=' + document.forms['menus-add-form'].elements['menus[menu_context]'].value;
    ajaxLoader(document.getElementById('place-holder-menus'), url);

    // Blink for visual effects
    Blink('place-holder-menus');
    return (false);
}

/**
 * Fill the user input box with selected menu context already in use.
 * User clicks a context from the list.
 */
function copy_text_to_input_box() {
    // span.innerText does not work in firefox, but in IE, Opera
    context = this.getAttribute('title');
    if (window.confirm('Load the context: [' + context + '] for demo lookup?')) {
        document.forms['menus-add-form'].elements['menus[menu_context]'].value = context;
        load_menu_status();
    }
    return (false);
}

var span = document.getElementsByTagName('span');
var length = span.length;
for (var i = 0; i < length; ++i) {
    if (span[i].className == 'copy-text') {
        span[i].onclick = copy_text_to_input_box;
    }
}