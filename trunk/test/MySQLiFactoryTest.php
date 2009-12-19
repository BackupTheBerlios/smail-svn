<?php

require_once 'PHPUnit/Framework.php';
require_once 'MySQLiFactory.php';

class MySQLiFactoryTest extends PHPUnit_Framework_TestCase {
	
	public function testGetInstance() {
		$instance = MySQLiFactory::getInstance();
		$this->assertNotNull($instance);
	}
}

?>