<?php
namespace backend;

/**
 * Generates loose type of licensing system
 */
class license
{
	public function __construct()
	{
	}

	public function verify($param1 = 'hard.disk.serial.number', $param2 = 'cpu.id', $challenge = 'code.sent.to.client.and.back')
	{
		if(!$challenge)
		{
			return false;
		}

		$response = $this->get_challenge($param1, $param2);

		return $response == $challenge;
	}

	public function get_challenge($param1 = 'hard.disk.serial.number', $param2 = 'cpu.id')
	{
		$server_key = 'sa.nj.aal.cor.ps';

		# Also, to add the IP is okay
		# By this way, the client will have limited mobility.
		# Not good for internet based.
		# But good for intranet based.
		$server_key .= $_SERVER['REMOTE_ADDR'];

		$challenge = md5("{$param2}{$server_key}{$param1}");

		return $challenge;
	}

	public function get_response($param1 = 'hard.disk.serial.number', $param2 = 'cpu.id')
	{
		return $this->get_challenge($param1, $param2);
	}
}

