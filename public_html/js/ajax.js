/**
 * Ajax super class for cross browser compatibility.
 * Inspired from W3school Articles
 */
function getXMLHTTPRequest() {
    var request = false;
    try {
        request = new XMLHttpRequest();
    }
    catch (err1) {
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (err2) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (err3) {
                request = false;
                alert('Your browser does not support ajax support. Upgrade!');
            }
        }
    }
    return (request);
}

function ajaxLoader(who, url) {
    if (!who || !url) return (false);
    //alert(url);

    var http = getXMLHTTPRequest();
    http.onreadystatechange = function () {
        if (http.readyState != 4 || http.status != 200) return (false);
        {
            //alert(http.responseText);
            try {
                if (typeof who != 'string') {
                    who.innerHTML = http.responseText;
                }
                else {
                    //alert(who+' should be an HTML ID.');
                    document.getElementById(who).innerHTML = http.responseText;
                }
            }
            catch (e) {
                alert("Can not write to HTML ID: < " + id + " > the following message: " + http.responseText);
            }
            return (true);
        }
    };
    http.open('GET', url, true);
    http.send(null);
    return (false);
}

/**
 * Establish a parser for XML string.
 */
function xml_string_parser(xml_string) {
    var xmlDoc = null;
    var parser = null;

    try {
        xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
        xmlDoc.async = "false";
        xmlDoc.loadXML(xml_string);
    }
    catch (e) {
        try {
            parser = new DOMParser();
            xmlDoc = parser.parseFromString(xml_string, "text/xml");
        }
        catch (e) {
            alert('Error: XML string paser can not establish.\n' + e.message);
        }
    }
    return (xmlDoc);
}

/**
 * The text blinker, for forcing to read it out.
 */
window.Blink = function (args) {
    // Set the color and seconds below, e.g., [args,'COLOR',SECONDS]
    args = (/,/.test(args)) ? args.split(/,/) : [args, '#FFD100', 10];
    var who = document.getElementById(args[0]);
    var count = parseInt(args[2]);
    if (--count <= 0) {
        who.style.backgroundColor = "";
        if (who.focus) who.focus();
    }
    else {
        args[2] = count + "";
        who.style.backgroundColor = (count % 2 == 0) ? "" : args[1];
        args = '\"' + args.join(',') + '\"';
        setTimeout("Blink(" + args + ")", 200);
    }
};

/**
 * Places a hit over an input box.
 * Shows the default value first. Once clicked on, empties and lets users type their own.
 * When focus is lost, hints again.
 * You may have to work extra in validations to avoid using the default hinting texts.
 * @example hint(document.forms['registration'].elements['email'], 'email@address.com');
 */
function hint(element, default_text) {
    if (!element.value) element.value = default_text;
    element.onfocus = function () {
        if (element.value == default_text) element.value = "";
        return true;
    };
    element.onblur = function () {
        if (element.value == "") element.value = default_text;
        return true;
    };
    return true;
}

/**
 * Click on an ID and apply the value to some other fields
 */
function click_put(who, where, what) {
    document.getElementById(who).onclick = function () {
        document.getElementById(where).value = what;
        return false;
    };
}

/**
 * Cancel file upload: Clears the file upload box and recreates it with empty values.
 */
function cancel_upload(parent_div) {
    var success = false;
    if (document.getElementById(parent_div)) {
        /**
         * @todo Variable is assigned to itself intentionally to clean up chosen file.
         * @type {string}
         */
        document.getElementById(parent_div).innerHTML = document.getElementById(parent_div).innerHTML;
        success = true;
    }
    return success;
}

/**
 * Post the Ajax Flags internally and stop from refreshing the list page
 * @see Reused over all validators/ENTITY/list.js
 * @todo Post with HTTP Referrer, ID and Code values
 */
function handle_ajax_flagging() {
    $(".data a.ajax").click(function () {
        var linked = $(this);
        $.post(this.href,
            {
                id: "",
                code: ""
            },
            function (data, status) {
                if (data == 'Y') {
                    src = linked.children('img').attr('src');
                    src = (src == './images/actions/cross.png') ? './images/actions/tick.png' : './images/actions/cross.png';
                    linked.children('img').attr('src', src);
                }
            });
        return false;
    });
}
