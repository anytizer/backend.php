/**
 * IE fix for objects
 * http://www.mix-fx.com/flash-prompt.htm
 * Avoids: "Click to activate and use this control"
 */

var theObjects = document.getElementsByTagName('object');
for (var i = 0; i < theObjects.length; ++i) {
    /**
     * @todo Variable is assigned to itself. Find and fix.
     * @type {*|string}
     */
    theObjects[i].outerHTML = theObjects[i].outerHTML;
}
