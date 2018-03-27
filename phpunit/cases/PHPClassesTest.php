<?php
namespace cases;

use PHPUnit\Framework\TestCase;

class PHPClassesTest extends TestCase
{
	public function testSimpleXmlElement()
	{
		$this->assertTrue(class_exists("\SimpleXMLElement"), "SimpleXMLElement not found");
	}
	
	public function testPdo()
	{
		$this->assertTrue(class_exists("\PDO"), "PDO not found");
	}

	public function testPdoStatement()
	{
		$this->assertTrue(class_exists("\PDOStatement"), "PDOStatement not found");
	}
	
	public function testSqlite()
	{
		// Probably through PDO Only
		//$this->assertTrue(function_exists("sqlite_open"), "SQLite not found");
		$this->markTestIncomplete();
	}
}