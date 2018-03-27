<?php
namespace cases;

$plugins = dirname(__FILE__)."/../../../library/plugins";

require_once($plugins."/modifier.suspense.php");
require_once($plugins."/modifier.tight.php");
require_once($plugins."/modifier.www.php");

use PHPUnit\Framework\TestCase;

class PluginsTest extends TestCase
{
	public function testWwwReplacemement()
	{
		$domain = "example.com";
		$converted = smarty_modifier_www($domain);
		
		$this->assertEquals("www.example.com", $converted);
	}
	
	public function testNonWwwReplacemement()
	{
		$domain = "www.example.com";
		$converted = smarty_modifier_www($domain);
		
		$this->assertEquals("www.example.com", $converted);
	}
	
	public function testTighten()
	{
		$text = " some 90 Messages ";
		$converted = smarty_modifier_tight($text);
		
		$this->assertEquals("some90Messages", $converted);
	}

	public function testSuspense()
	{
		$text = " some 90 Messages ";
		$converted = smarty_modifier_suspense($text);
		
		$this->assertNotEquals($text, $converted);
	}
}