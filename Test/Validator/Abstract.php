<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class Validator_Test_Class extends XeroPoint_Validator_Abstract {
	
	public function test($value) {
		return $value == 123;
	}
}

class XeroPoint_Test_Validator_Abstract extends PHPUnit_Framework_TestCase {
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Validator_Abstract
	 */
	private $testObject;
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new Validator_Test_Class ();
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
	 * tests that the test method returns correct result
	 * 
	 */
	public function testTestWithValidValue() {
		$this->assertTrue ( $this->testObject->test ( 123 ), 'incorrect validation result with integer test' );
		$this->assertTrue ( $this->testObject->test ( '123' ), 'incorrect validation result with string test' );
	}
	
	/**
	 * tests that the test method returns correct result
	 * 
	 */
	public function testTestWithInvalidValue() {
		$this->assertFalse ( $this->testObject->test ( 321 ), 'incorrect validation result with invalid integer test' );
	}
	
	/**
	 * tests that the validator performs correctly with empty parameter passed
	 * 
	 */
	public function testTestWithEmptyValue() {
		$this->assertFalse ( $this->testObject->test (), 'incorrect validation result for empty parameter' );
	}
}