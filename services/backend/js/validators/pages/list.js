/**
 * Install on-change handler for listed subdomains.
 */
document.forms['subdomains-pages'].elements['subdomain_id'].onchange = function () {
    document.forms['subdomains-pages'].submit();
    return (false);
};

/**
 * Handles removal of a particular page.
 */
function handle_delete() {
    return (window.confirm('Are you sure, you want to delete this page?'));
}

/**
 * This page needs ADMIN Login!, reset the flag
 */
function handle_admin_login_needed() {
    id = parseInt(this.getAttribute('rel'));
    if (reset_login = window.confirm('Reset ADMIN Login for page ID: ' + id + '?\r\nOnly admin can access this page later on.')) {
        window.location = 'pages-reset-admin.php?id=' + id;
    }
    return (false);
}

/**
 * This page needs LOGIN to access, reset the flag
 */
function handle_login_needed() {
    id = parseInt(this.getAttribute('rel'));
    //alert(window.location);
    if (reset_login = window.confirm('Set/Reset login requirements for page ID: ' + id + '?\r\nOnly logged in users can see the contents later on.')) {
        window.location = 'pages-reset-login.php?id=' + id;
    }
    return (false);
}

/**
 * Confirms whether to load the contents of a page.
 * It may be harmful in several ways:
 *  - Can alter the contents or exectue the page scripts.
 *  - Page being listed may not be of the current sub-domain service name (404 Error?).
 *  - Can clear up the contents or execute harmful scripts.
 */
function handle_load_listing_contents() {
    return (window.confirm('Are you sure, you want to load this page and execute the scripts? It may cause harms and defects.'));
}

/**
 * Installs confirmation for delete-icons
 */
var images = document.getElementsByTagName('img');
for (var i = 0; i < images.length; ++i) {
    switch (images[i].className) {
        case 'icon-delete':
            images[i].onclick = handle_delete;
            break;
        case 'icon-list':
            images[i].onclick = handle_load_listing_contents;
            break;
        case 'icon-admin':
            images[i].onclick = handle_admin_login_needed;
            images[i].title = 'Admin only';
            break;
        case 'icon-login':
            images[i].onclick = handle_login_needed;
            images[i].title = 'Require login';
            break;
        default:
            break;
    }
}

handle_ajax_flagging();