// Validate EDIT form - __ENTITY__
var v = new Validator('__ENTITY__-edit-form');
v.EnableMsgsTogether();

__JAVASCRIPT_EDIT_FIELDS__;

document.forms['__ENTITY__-edit-form'].elements[0].focus();