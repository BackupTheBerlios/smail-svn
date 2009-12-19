<?php
/*
 * Run this file via:
 * shell> phpunit PhpUnitTests.php
 */

require_once 'PHPUnit/Framework.php';

class PhpUnitTests {
	
	public static function suite() {
		$suite = new PHPUnit_Framework_TestSuite('SMAIL');
		self::addTests($suite);
		return $suite;
	}
	
	public static function addTests(&$suite) {
		$testDir = 'test/';
		$handle = opendir($testDir);
		while (($file = readdir($handle)) !== false) {
			if (substr($file, -8) == 'Test.php') {
				require_once $testDir.$file;
				$suite->addTestSuite(substr($file, 0, -4));
			}
		}
		closedir($handle);
	}
	
}
?>