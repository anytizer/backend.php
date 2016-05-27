<!-- Created on: 2010-10-06 12:53:18 781 -->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul>
		<li><a href="smtp-add.php"><img src="{'add'|icon}"/> Add SMTP</a></li>
		<li><a href="smtp-list.php"><img src="{'table'|icon}"/> List SMTP</a></li>
	</ul>
</div>
<!-- admmin details for smtp -->
<div class="details">
	<div><strong>SMTP ID</strong>: {$smtp.smtp_id}</div>
	<div><strong>Subdomain ID</strong>: {$smtp.subdomain_id}</div>
	<div><strong>SMTP Identifier</strong>: <strong>{$smtp.smtp_identifier}</strong></div>
	<div><strong>Host</strong>: {$smtp.smtp_host}</div>
	<div><strong>Port</strong>: {$smtp.smtp_port}</div>
	<div><strong>Authenticate</strong>: {$smtp.do_authenticate}</div>
	<div><strong>Username</strong>: {$smtp.smtp_username}</div>
	<div><strong>Password</strong>: {$smtp.smtp_password}</div>
	<div><strong>From Name</strong>: {$smtp.from_name}</div>
	<div><strong>From Email</strong>: {$smtp.from_email}</div>
	<div><strong>Reply-To Name</strong>: {$smtp.replyto_name}</div>
	<div><strong>Reply-To Email</strong>: {$smtp.replyto_email}</div>
	<div><strong>SMTP Comments</strong>: {$smtp.smtp_comments}</div>
	<div><strong>Test it</strong>: <a
			href="smtp-test.php?code={$smtp.smtp_identifier}">Sends a test email to developer using this account</a>
	</div>
	
<div class="holder">
	<div class="title">PHP Code</div>
	<div class="content">
		<pre>
$email_template = new email_template(<strong>EMAILTEMPLATE_CODE</strong>);
<em>$sender</em> = new sender('<strong>{$smtps.smtp_identifier|default:'-'}</strong>'); # CONTACTUS_SENDERSMTP
$sender->ClearAddresses();

# Developer monitors the emails till the development of the website
# $sender->add_recipient(new datatype_recipient(<strong>DEVELOPER_EMAIL</strong>, <strong>DEVELOPER_NAME</strong>));

# Send email to the administrator
# $sender->add_recipient(new datatype_recipient(<strong>CONTACTUS_ADMINEMAIL</strong>, <strong>CONTACTUS_ADMINNAME</strong>));

# Replies back to the messenger
# $sender->AddReplyto(<strong>$email</strong>, <strong>$name</strong>);

<em>$data</em> = array(
	'KEY' => 'VALUE',
);
<em>$template_data</em> = $email_template->read_template(<strong>$data</strong>);
<em>$success</em> = $sender->deliver(<em>$template_data</em>);
if(<em>$success</em>)
{
	$messenger = new messenger('success', 'Your inquiry has been successfully forwarded.');
}</pre>
	</div>
</div>
	
</div>
<!-- End of smtp Details (Admin) -->