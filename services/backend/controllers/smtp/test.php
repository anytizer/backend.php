<?php


# Created on: 2010-10-06 12:53:18 781

/**
 * Sends a test email using the preferred smtp identifier code
 *
 * @link smtp-test.php?code=201204271357108953
 */

$code = $variable->get('code', 'string', '');

$email_template = new \backend\email_template('201204301504529384'); # Test email template
$sender = new \backend\sender($code);
$sender->ClearAddresses();

# Send email to the administrator
$sender->add_recipient(new \others\datatype_recipient(DEVELOPER_EMAIL, 'Bimal Poudel'));
$sender->AddBCC('emailtest@example.com', 'Test Sender');

$data = array(
	'CODE' => $code,
);
$template_data = $email_template->read_template($data);
$success = $sender->deliver($template_data);
if(!$success)
{
	header('Content-Type: text/plain');

	echo $sender->ErrorInfo;
	print_r($sender);

	die('Failed to send email.');
}
else
{
	die('The test passed successfully. An email should have been generated now. Please check ' . DEVELOPER_EMAIL);
}
