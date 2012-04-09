<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Test_Validator_Alpha extends PHPUnit_Framework_TestCase {
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Validator_Alpha
	 */
	private $testObject;
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new XeroPoint_Validator_Alpha ();
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
		$this->assertTrue ( $this->testObject->test ( 'abcABC' ), 'incorrect validation result with alphabetical string test' );
	}
	
	/**
	 * tests that the test method returns correct result
	 * 
	 */
	public function testTestWithInvalidValue() {
		$this->assertFalse ( $this->testObject->test ( 'abc123' ), 'incorrect validation result with invalid letter and integer test' );
		$this->assertFalse ( $this->testObject->test ( '123' ), 'incorrect validation result with invalid integer test' );
		$this->assertFalse ( $this->testObject->test ( 'ab c' ), 'incorrect validation result with space in string' );
	}
	
	/**
	 * tests that the validator performs correctly with empty parameter passed
	 * 
	 */
	public function testTestWithEmptyValue() {
		$this->assertFalse ( $this->testObject->test (), 'incorrect validation result for empty parameter' );
		$this->assertTrue ( 1 == count ( $this->testObject->getErrorMessages () ), 'incorrect number of error messages' );
	}
}