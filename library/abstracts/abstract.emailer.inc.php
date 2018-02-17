<?php
namespace abstracts;
use \common\mysql;

/**
 * Interfaces an email sending process with lock marker
 *
 * Class emailer
 * @package abstracts
 */
abstract class emailer
    extends mysql
{
    private $sender; # The mail delivery engine

    private $send_limits = 0; # 50 emails at a time
    private $sent_counter = 0; # ZERO

        public function __construct($email = "", $name = "")
    {
        /**
         * Safety of the sender
         */
        if ($email == "" || $name == "") {
            \common\stopper::message("Please give email/name immediately while you instantiate emailer.");
        }

        # Establish the database connection
        parent::__construct();

        $this->send_limits = 0; # 50 emails at a time: Should be fixed with limits()
        $this->sent_counter = 0; # ZERO

        /**
         * Immediately define, who should read this email's response?
         */
        $this->sender = new sender('TEST');
        $this->sender->clearReplyTos();
        $this->sender->addReplyTo($email, $name);
    } # Get data for current sequence

        /**
     * Sets the number of emails to send per call.
     */
    public function limits($send_limits = 0)
    {
        $this->send_limits = (int)$send_limits;
    } # Lock the running email recipient (id)

        /**
     * Processes the sending queue under some limits
     */
    public function send($template_code = "")
    {
        # JOBS:EMPL-PROPOSAL
        $email_template = new email_template($template_code);
        # \common\stopper::debug($email_template, false);
        # \common\stopper::message('Blank template');

        # Reset the {CSS} tag as well.

        while ($recipient_data = $this->next_recipient()) {
            # Verify the columns.
            # Problem: Does not need to loop, once only.
            if (!array_key_exists('id', $recipient_data) || !array_key_exists('name', $recipient_data) || !array_key_exists('email', $recipient_data)) {
                \common\stopper::message('One of ID/Name/Email columns not found in Recipient Data: ' . implode(', ', array_keys($recipient_data)));
            }

            #\common\stopper::debug($recipient_data, false);
            \common\stopper::message("\r\nSending to: {$recipient_data['name']} <{$recipient_data['email']}>");

            # Necessary Keys:
            # email   : recipient email
            # name    : recipient name
            # id      : action on
            # is_sent : Lock marker

            # Add recipients
            $this->sender->ClearAddresses(); # Optional
            $this->sender->add_recipient(new datatype_recipient($recipient_data['email'], $recipient_data['name'])); # Real recipient

            $email_data = $email_template->read_template($recipient_data);
            #\common\stopper::debug($recipient_data, false);
            #\common\stopper::debug($email_data, false);
            #\common\stopper::message('.........');

            # Send the email now
            if ($this->sender->deliver($email_data)) {
                # Stop sending this email again: locks the user
                $this->lock_recipient($recipient_data['id']);
            } else {
                # Stop sending this email again: locks the user
                $this->error_sending($recipient_data['id']);
                #echo("\r\nSending Failed to: {$recipient_data['email']}");
            }


            /**
             * Do not remove this section. It helps to terminate sending emails in one session once the limits are met.
             */
            if ($this->sending_limits_over()) {
                break;
            }
        }
    } # Error sending to this email recipient (id)

abstract public function next_recipient();

abstract public function lock_recipient();

abstract public function error_sending();

    /**
     * Determines, when to stop sending emails
     * Also, stops for some milliseconds to prevent traffic
     */
    protected function sending_limits_over()
    {
        #usleep(500000); # Delay sending message
        $sending_limits_over = (++$this->sent_counter >= $this->send_limits);
        return $sending_limits_over;
    }
}
