<?php
namespace backend;

/**
 * Reads an email template
 */
class email_template
    extends \common\mysql
{
    private $template;
    # subject, html, text
    # email_subject, email_html, email_text

    /**
     * Email Template Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function setup($email_code = 'WELCOME', $language = 'EN')
    {
        # Choose the Language of a customer
        $headers = new \common\headers();
        $language = (!$language) ? $headers->language() : $language;
        $template_sql = "
SELECT
	`email_subject` `subject`,
	`email_html` `html`,
	`email_text` `text`,
	IF(`email_language`='EN', 99, 0) `sorter`
FROM `query_emails`
WHERE
	`email_code`='{$email_code}'
	AND `is_active`='Y'
ORDER BY
	`sorter` ASC
LIMIT 1
;";

        /*
            #AND (
            #	`email_language`='EN'
            #	OR `email_language`='{$language}'
            #)
        # Optionally kept for reference only
                $template_sql = "
        SELECT
            email_subject `subject`,
            email_html `html`,
            email_text `text`
        FROM query_emails
        WHERE
            email_code='{$email_code}'
            AND is_active='Y'
        ;";*/
        if ($template = $this->row($template_sql)) {
        } else {
            # Template was NOT read out
            $template['subject'] = 'Template Subject - Error Reading';
            $template['html'] = "Error reading template: <strong>$email_code</strong> HTML. Check, if the template is ACTIVE.";
            $template['text'] = "Error reading template text ($email_code). Check, if the template is ACTIVE.";
        }
        #\common\stopper::debug($template, false);
        $this->template = new \others\datatype_email($template['subject'], $template['html'], $template['text']);
    }

    /**
     * Replaecs the email contents with the data(associative) and returns a customized email template.
     *
     * @param $data array
     *
     * @return datatype_email (email_subject, email_html, email_text)
     */
    function read_template($data = array())
    {
        /**
         * @todo $data keys should NOT contain { and } as boundaries.
         */

        if (!$data) {
            return false;
        }

        # Import the template skeleton into a local variable
        #$template = $this->template; # a copy of datatype_email class
        #$template = clone $this->template; # a copy of datatype_email class
        $template = new \others\datatype_email($this->template->subject, $this->template->html, $this->template->text);
        #\common\stopper::debug($template, false);
        #\common\stopper::message('Template cloned');

        /**
         * Customize the email, with basic replacement
         */
        foreach ($data as $key => $value) {
            # # Replace all possible with the values in the column
            $template->subject = preg_replace("/\{[\$]*{$key}\}/is", $value, $template->subject);
            $template->html = preg_replace("/\{[\$]*{$key}\}/is", $value, $template->html);
            $template->text = preg_replace("/\{[\$]*{$key}\}/is", $value, $template->text);
        }

        /**
         * Close all tags - Do not leave the {...} fields blank
         */
        $template->subject = preg_replace("/\{[\$]*[a-z0-9]+\}/is", "", $template->subject);
        $template->html = preg_replace("/\{[\$]*[a-z0-9]+\}/is", "", $template->html);
        $template->text = preg_replace("/\{[\$]*[a-z0-9]+\}/is", "", $template->text);

        /**
         * htmlspecialchars_decode: Optional
         */
        #$template->subject = htmlspecialchars($template->subject);
        #$template->html = htmlspecialchars($template->html);
        #$template->text = htmlspecialchars($template->text);

        #\common\stopper::debug($this->template, false);
        #\common\stopper::message('original template');
        #\common\stopper::debug($template, false);
        #\common\stopper::message('Before/after');
        #\common\stopper::message("[Before]: {$this->template}, [After]: {$template}");

        return $template;
    }
}

