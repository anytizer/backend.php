<?php
namespace cases;

use PHPUnit\Framework\TestCase;

class PhpIniConfigurationsTest extends TestCase
{
	/**
	 * Most common configurations
	 */
	public function testPhpIniConfigurations()
	{
		$this->assertEquals(ini_get("allow_call_time_pass_reference"), false, "Allow call time pass by reference.");
		$this->assertEquals(ini_get("default_charset"), "UTF-8", "Errors hidden.");
		$this->assertEquals(ini_get("display_errors"), "stderr", "Errors hidden.");
		$this->assertEquals(ini_get("error_reporting"), E_ALL|E_STRICT, "Error Reporting is something else.");
		$this->assertEquals(ini_get("ignore_user_abort"), true, "Ignore User Abort configuration.");
		$this->assertEquals(ini_get("max_execution_time"), 0, "Max Execution Time");
		$this->assertEquals(ini_get("max_input_time"), -1, "Max Input Time");
		$this->assertEquals(ini_get("memory_limit"), -1, "Memory limit restrictions on this server.");
		$this->assertEquals(ini_get("output_buffering"), 0, "Output Buffering.");
		$this->assertEquals(ini_get("safe_mode"), false, "Safe Mode.");
		$this->assertEquals(ini_get("set_time_limit"), false, "Set Time Limit");
	}

	/**
	 * Error logging
	 */
	public function testErrorLog()
	{
		$this->assertEquals(!empty(ini_get("error_log")), true, "Error Log File name is empty.");
		$this->assertEquals(ini_get("log_errors"), true, "Errors not logged somewhere.");
	}

	/**
	 * Other configurations
	 */
	public function testAllowUrl()
	{
		$this->assertEquals(ini_get("allow_url_fopen"), true, "Allow URL FOpen.");
		$this->assertEquals(ini_get("allow_url_include"), false, "Allow URL Include.");
	}

	/**
	 * Upload capabilities
	 */
	public function testUploads()
	{
		$this->assertEquals(ini_get("upload_max_filesize"), "512M", "Upload Max File Size.");
		$this->assertEquals(ini_get("post_max_size"), "512M", "Post Max Size.");
		$this->assertEquals(ini_get("max_file_uploads"), "8", "Max File Uploads.");
	}

	/**
	 * Short tags - disabled
	 */
	public function testShortTags()
	{
		$this->assertEquals(ini_get("asp_tags"), false, "ASP Tags.");
		$this->assertEquals(ini_get("short_open_tag"), false, "Short Open Tag.");
	}

	/**
	 * Auto management
	 */
	public function testAutoFeatures()
	{
		$this->assertEquals(ini_get("auto_append_file"), "", "Auto Append File.");
		$this->assertEquals(ini_get("auto_prepend_file"), "", "Auto Prepend File.");
		$this->assertEquals(ini_get("disable_classes"), "", "Disabled Classes.");
		$this->assertEquals(ini_get("disable_functions"), "", "Disabled Functions.");
	}

	/**
	 * Register globals
	 */
	public function testRegisterGlobals()
	{
		$this->assertEquals(ini_get("register_globals"), false, "Register Globals.");
		$this->assertEquals(ini_get("register_long_arrays"), false, "Register Long Arrays.");
		$this->assertEquals(ini_get("request_order"), "GPC", "Request Order.");
		$this->assertEquals(ini_get("register_argc_argv"), true, "Request argc argv."); // not set
		$this->assertEquals(ini_get("auto_globals_jit"), false, "Request argc argv.");
		$this->assertEquals(ini_get("variables_order"), "GPCSE", "Variables Order.");
	}
		
	/**
	 * Deprecated configurations
	 */
	public function testMagicQuotes()
	{
		$this->assertEquals(ini_get("magic_quotes_gpc"), false, "Magic Quotes GPC.");
		$this->assertEquals(ini_get("magic_quotes_runtime"), false, "Magic Quotes Runtime.");
	}

	/**
	 * MySQLi
	 */
	public function testMysqli()
	{
		$this->assertEquals(ini_get("mysqli.max_persistent"), -1, "MySQLi Persistent Connections.");
		$this->assertEquals(ini_get("mysqli.allow_persistent"), true, "Allow MySQLi Persistent Connection.");
	}
}
