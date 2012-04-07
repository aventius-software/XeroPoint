<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class Control_Test_Class extends XeroPoint_Control_Abstract {
	
	protected function getControlHtml() {
		return '<div>control html</div>';
	}
}

class XeroPoint_Test_Control_Abstract extends PHPUnit_Framework_TestCase {
	
	/**
	 * test ID of the control
	 * 
	 * @var string
	 */
	const TEST_CONTROL_ID = 'test_control';
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Control_Abstract
	 */
	private $testObject;
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new Control_Test_Class ( self::TEST_CONTROL_ID, XeroPoint_Control_Abstract::METHOD_POST );
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
	 * Constructs the test case.
	 * 
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/**
	 * test that the control returns its ID correctly
	 * 
	 */
	public function testGetID() {
		$this->assertTrue ( self::TEST_CONTROL_ID == $this->testObject->getID (), 'control ID was incorrectly identified' );
	}
	
	/**
	 * test the default max length of the control is 255 characters
	 * 
	 */
	public function testGetMaxLength() {
		$this->assertTrue ( 255 == $this->testObject->getMaxLength (), 'invalid max length was returned' );
	}
	
	/**
	 * test that setting the max length with negative value throws exception
	 * 
	 */
	public function testSetMaxLengthFailsWithNegativeValue() {
		try {
			// first test negative number length is not allowed - should throw exception
			$this->testObject->setMaxLength ( - 1 );
		} 

		catch ( Exception $expected ) {
			return;
		}
		
		$this->fail ( 'an expected exception has not been raised.' );
	}
	
	/**
	 * test that setting the max length with a string value throws exception
	 * 
	 */
	public function testSetMaxLengthFailsWithStringValue() {
		try {
			// first test negative number length is not allowed - should throw exception
			$this->testObject->setMaxLength ( 'abc' );
		} 

		catch ( Exception $expected ) {
			return;
		}
		
		$this->fail ( 'an expected exception has not been raised.' );
	}
	
	/**
	 * test that setting the max length with a integer value is ok
	 * 
	 */
	public function testSetMaxLengthPassesWithIntegerValue() {
		$this->assertTrue ( $this->testObject->setMaxLength ( 123 ) instanceof XeroPoint_Control_Abstract, 'invalid object returned' );
	}
	
	/**
	 * tests the correct method type has been set
	 * 
	 */
	public function testGetMethod() {
		$this->assertTrue ( XeroPoint_Control_Abstract::METHOD_POST == $this->testObject->getMethod (), 'incorrect method returned' );
	}
	
	/**
	 * tests that the label html code is correct
	 * 
	 */
	public function testGetLabelHtml() {
		$this->testObject->setLabel ( 'hello' );
		
		$expectedHtml = '<label id="' . self::TEST_CONTROL_ID . '_label" for="' . self::TEST_CONTROL_ID . '">hello</label>';
		$actualHtml = $this->testObject->getLabelHtml ();
		
		echo "\nACTUAL LABEL HTML:\n$actualHtml";
		
		$this->assertTrue ( $expectedHtml == $this->testObject->getLabelHtml (), 'incorrect label html found' );
	}
}

