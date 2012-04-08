<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Test_Control_Submit extends XeroPoint_Test_Control_Button {
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new XeroPoint_Control_Submit ( self::TEST_CONTROL_ID );
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
	 * tests that the button html is correctly formed
	 * 
	 */
	public function testGetHtml() {
		$this->testObject->setLabel ( 'submit text' );
		
		$expected = '<p id="' . self::TEST_CONTROL_ID . '_container"><button id="' . self::TEST_CONTROL_ID . '" type="submit">submit text</button></p>';
		$actual = $this->testObject->getHtml ();
		
		echo "\nHTML FOR SUBMIT CONTROL:\n$actual\n";
		
		$this->assertTrue ( $expected == $actual, 'incorrect submit html found' );
	}
}

