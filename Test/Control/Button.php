<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Test_Control_Button extends XeroPoint_Test_Control_Abstract {
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new XeroPoint_Control_Button ( self::TEST_CONTROL_ID );
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
		$this->testObject->setLabel ( 'button text' );
		
		$expected = '<p id="' . self::TEST_CONTROL_ID . '_container"><button id="' . self::TEST_CONTROL_ID . '" type="button">button text</button></p>';
		$actual = $this->testObject->getHtml ();
		
		echo "\nHTML FOR BUTTON CONTROL:\n$actual\n";
		
		$this->assertTrue ( $expected == $actual, 'incorrect button html found' );
	}
}

