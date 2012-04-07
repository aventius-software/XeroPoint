<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Test_Control_TextBox extends XeroPoint_Test_Control_Abstract {
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new XeroPoint_Control_TextBox ( self::TEST_CONTROL_ID );
	}
	
	/**
	 * Cleans up the environment after running a test.
	 * 
	 */
	protected function tearDown() {
		$this->testObject = null;
		parent::tearDown ();
	}
	
	/**
	 * tests that the textbox html is correctly formed
	 * 
	 */
	public function testGetHtml() {
		$expected = '<input id="' . self::TEST_CONTROL_ID . '" type="text" maxlength="255" value=""/>';
		$actual = $this->testObject->getHtml ();
		
		echo "\nHTML FOR TEXTBOX CONTROL:\n$actual\n";
		
		$this->assertTrue ( $expected == $actual, 'incorrect textbox html found' );
	}
}

