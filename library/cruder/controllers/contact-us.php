<?php
#__DEVELOPER-COMMENTS__

/**
 * Sends the website inquiry messages to the administrators
 */

if ($variable->post('submit_button', 'string', "")) {
    # Verify that it is a human with javascript enabled browser.
    if ($variable->post('noemail', 'string', "") || $variable->post('nospam', 'string', "") != 'nospam') {
        $messenger = new \common\messenger('error', 'You cannot misuse our contact form!');
        \common\stopper::url('./');
    }

    /*
    $messages = array(
        'subdomain_id' => $subdomain_id,
        'added_on' => time(),
        'is_active' => 'Y',
        'is_approved' => 'Y',
        
        'contact_ip' => $_SERVER['REMOTE_ADDR'],
        'contact_host' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
        'contact_browser' => $_SERVER['HTTP_USER_AGENT'],
        
        'contact_name' => $variable->post('name', 'string', ""),
        'contact_email' => $variable->post('email', 'string', ""),
        'contact_subject' => $variable->post('subject', 'string', ""),
        'contact_message' => $variable->post('message', 'string', ""),
    );
    $contacts = new contacts();
    $message_id = $contacts->add_quick($messages);
    */

    die('Replace CONTACTUS_EMAILTEMPLATE, CONTACTUS_SENDERSMTP, CONTACTUS_ADMINEMAIL, CONTACTUS_ADMINNAME : ' . __FILE__ . ', ' . __LINE__); # use the proper template ID
    $defines = array(
        'CONTACTUS_EMAILTEMPLATE',
        'CONTACTUS_SENDERSMTP',
        'CONTACTUS_ADMINEMAIL',
        'CONTACTUS_ADMINNAME',
    );
    foreach ($defines as $d => $define) {
        if (!defined($define)) {
            die('Contact Us definition parameter(s) missing: ' . $define);
        }
    }

    $email_template = new email_template(CONTACTUS_EMAILTEMPLATE);
    $sender = new sender(CONTACTUS_SENDERSMTP);
    $sender->ClearAddresses();

    # Developer monitors the emails till the development of the website
    # $sender->add_recipient(new datatype_recipient(DEVELOPER_EMAIL, DEVELOPER_NAME));

    # Send email to the administrator
    $sender->add_recipient(new datatype_recipient(CONTACTUS_ADMINEMAIL, CONTACTUS_ADMINNAME));

    # Replies back to the messenger
    $sender->AddReplyto($variable->post('email', 'string', ""), $variable->post('name', 'string', ""));

    $data = array(
        'NAME' => $variable->post('name', 'string', ""),
        'EMAIL' => $variable->post('email', 'string', ""),
        'SUBJECT' => $variable->post('subject', 'string', ""),
        'MESSAGE' => $variable->post('message', 'string', "")
    );
    $template_data = $email_template->read_template($data);
    $success = $sender->deliver($template_data);

    $messenger = new \common\messenger('success', 'Your inquiry has been successfully forwarded to the administrator. Please wait for a response.');

    \common\stopper::url('./');
}
