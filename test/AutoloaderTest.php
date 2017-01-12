<?php

use Jundar\Autoloader;

class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
	public function testLoadClass()
	{
		$autoloader = new Autoloader();
		$autoloader->addPrefix("Test", __DIR__ . "/test-classes");
		$autoloader->register();
		$this->assertTrue(class_exists("Test\\TestClass"));
	}

	public function testLoadNonexistentClass()
	{
		$autoloader = new Autoloader();
		$autoloader->addPrefix("Test", __DIR__ . "/test-classes");
		$autoloader->register();
		$this->assertFalse(class_exists("ABC\\DEF\\GHI"));
	}
}

?>