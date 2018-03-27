<?php
namespace cases;

use PHPUnit\Framework\TestCase;

class PHPExtensionsTest extends TestCase
{
	public function testSplAutoloadRegister()
	{
		$this->assertTrue(function_exists("spl_autoload_register"));
	}

	public function testGdInfo()
	{
		$this->assertTrue(function_exists("gd_info"));
	}
	
	public function testCurlInit()
	{
		$this->assertTrue(function_exists("curl_init"));
	}
	
	public function testMultiByteString()
	{
		$this->assertTrue(function_exists("mb_check_encoding"));
	}

	public function testXdebugInstalled()
	{
		$this->assertTrue(function_exists("xdebug_get_profiler_filename"));
	}
}