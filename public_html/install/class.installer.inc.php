<?php

/**
 * Generates valid licenses for installation.
 */
class installer
{
    public $company_name = "";
    public $installed_datetime = "";
    public $server_name = "";
    public $license_key = "";

    public function __construct()
    {
        $this->company_name = "Company Name";
        $this->installed_on = @date("YmdHis") . mt_rand(1000, 9999);
        $this->server_name = $_SERVER["SERVER_NAME"]??"localhost";
        $this->license_key = $this->license_key();
    }

    /**
     * Some logic to generate the license code.
     * We should be able to finger it back later on.
     * May implement validation from a license server.
     */
    private function license_key()
    {
        # Must get the whole license code from the remote server.

        # Send company name, installed on, server name to the remove server.
        # It will return the license text.
        # The server will keep the record of these licenses.

        $protection_key = "backend";
        $license_key = md5("{$protection_key}{$this->installed_datetime}{$this->server_name}");
		$license_key = strtoupper($license_key);

        return $license_key;
    }
}
