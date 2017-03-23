/**
 * Disable right mouse click Script
 * By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
 * For full source code, visit http://www.dynamicdrive.com
 *
 * Modified by Bimal Poudel
 * Just, externally add this script at the bottom of the page
 * you want to block the right click.
 */

/**
 * Inform the user why right click was blocked.
 */
function block_right_click() {
    var message = "Right Click has been disabled in this page to prevent unauthorised usage of images or texts.";
    //window.alert(message);
    return false;
}

function clickIE4() {
    if (event.button == 2) {
        block_right_click();
    }
    return false;
}

function clickNS4(e) {
    if (document.layers || document.getElementById && !document.all) {
        if (e.which == 2 || e.which == 3) {
            block_right_click();
        }
    }
    return (false);
}

/**
 * Install the right-click-block handlers
 */

if (document.layers) {
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown = clickNS4;
}
else if (document.all && !document.getElementById) {
    document.onmousedown = clickIE4;
}

document.oncontextmenu = block_right_click;
//new Function("block_right_click(); return false;");