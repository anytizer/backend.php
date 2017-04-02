<style type="text/css">
    <!--
    /** inner table */
    .chat-alternatives td {
        white-space: nowrap;
    }

    p.r {
        text-align: right;
    }

    -->
</style>
<form autocomplete="off" id="contact_form" name="contact_form" method="post" action="contact.php">
    <table class="contact_form">
        <tr>
            <td class="r" width="200">Your <strong>Name</strong>:</td>
            <td><input type="text" name="sender[name]" value="" class="input"/></td>
        </tr>
        <tr>
            <td class="r">Your <strong>Email</strong>:</td>
            <td><input type="text" name="sender[email]" value="" class="input" placeholder="email address"/></td>
        </tr>
        <tr>
            <td class="r">Message Subject</td>
            <td><input type="text" name="message[subject]" value="" class="input"/></td>
        </tr>
        <tr>
            <td><p class="r">Message, Reasons, Queries:</p>

                <h3>Chat Alternatives</h3>
                <table class="chat-alternatives">
                    <tr>
                        <td class="r">Skype:</td>
                        <td><strong>Yes</strong></td>
                    </tr>
                    <tr>
                        <td class="r">Google Talk:</td>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <td class="r">MSN:</td>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <td class="r">Yahoo:</td>
                        <td>Yes</td>
                    </tr>
                </table>
                <p>We hide the email addreses for first time contacts. So, google, yahoo and MSN contacts are NOT
                    published. When you contact us once, we will give them to you.</p>
            </td>
            <td><textarea name="message[message]" class="textarea"></textarea></td>
        </tr>
        <tr>
            <td class="r">!!No SPAM!!</td>
            <td><label> <input type="checkbox" name="nospam" value="agreed" checked="checked"
                               class="checkbox"/> I guarantee that my message is not a spam. </label>
            </td>
        </tr>
        <tr>
            <td class="r">&nbsp;</td>
            <td style="padding-top:10px;">
                <!--{* [contact - 12:11EE064750 ], [test - 1:254FF9706B] *}-->
                <input type="hidden" name="contact_quick" value="contact"/> <input type="hidden" name="CONTACT_KEY"
                                                                                   value="12:11EE064750"/> <input
                    type="hidden" name="HTTP_REFERER" value="/"/> <input type="input"
                                                                         name="email"
                                                                         value="you@domain.com"
                                                                         style="display:none;"/>
                <!-- For spam control -->
                <input type="submit" name="send-email" value="Contact now"
                       class="submit"/> This will generate an email to our staff.
            </td>
        </tr>
    </table>
</form>
<!-- This form demonsrates how to use our contact forwarding API -->
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
<script type="text/javascript">
    var v = new Validator('contact_form');
    v.addValidation('sender[name]', 'req', 'Your name please');
    v.addValidation('sender[email]', 'req', 'Your email please');
    v.addValidation('sender[email]', 'email', 'Give your email address correctly');
    v.addValidation('message[subject]', 'req', 'Message subject');
    v.addValidation('message[body]', 'req', 'Message text');
</script>