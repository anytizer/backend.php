<?php
namespace others;

/**
 * Send SMS using Nepal Telecom's Web SMS Service
 * Details at: http://websmsnew.ntc.net.np/websmss/
 *
 * @author Bimal Poudel <sms@bimal.org.np>
 */
class ntc
    extends curl
{
    private $login_details;

    public function login(datatype_ntc $login_details)
    {
        $this->login_details = $login_details;

        $data = array();

        $data['flag'] = '1';

        $data['username'] = $login_details->username;
        $data['password'] = $login_details->password;

        # The submit button
        $data['submit_x'] = 24;
        $data['submit_y'] = 12;

        $page_1 = $this->post('http://websms.ntc.net.np/login.jsp', $data);

        return $page_1;
    }

    public function send($destination = '000-000-0000', $message = "")
    {
        $data = array();
        $data['dest_no'] = $destination;
        $data['senddate'] = "";
        $data['btn_senddate'] = "";
        $data['message'] = $this->clean_sms_text($message);
        #$data['preset'] = "";
        $data['mlength'] = strlen($data['message']); # '142';
        $data['mlengthby'] = '/ 142';
        $data['Submit'] = 'Send';

        $page_2 = $this->post('http://websms.ntc.net.np/sendMsg.jsp', $data);

        return $page_2;
    }

    /**
     * allowed length of NTC sms message
     */
    private function clean_sms_text($text = "")
    {
        return substr($text, 0, 142);
    } # clean_sms_text()
}
