<?php
namespace others;

/**
 * Nepal Telecom Data Type
 *
 * @package Interfaces
 */
class datatype_ntc
    extends \abstracts\datatype
{
    public function __construct($username = "", $password = "")
    {
        parent::__construct(array(
            'username',
            'password'
        ));

        $this->username = \common\tools::sanitize($username);
        $this->password = \common\tools::sanitize($password);
    }
}
