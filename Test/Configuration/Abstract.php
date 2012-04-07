<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class Configuration_Test_Class extends XeroPoint_Configuration_Abstract {
	
	public function getApplicationName() {
		return 'test application';
	}
}

class XeroPoint_Test_Configuration_Abstract extends PHPUnit_Framework_TestCase {
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Configuration_Abstract
	 */
	private $testObject;
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new Configuration_Test_Class ();
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
	 * test that the application has booted and has the required configuration that it should
	 * 
	 */
	public function testConfigurationModeDetection() {
		$mode = $this->testObject->getMode ();
		$this->assertTrue ( 'Class' == $mode, 'configuration mode detection failed (mode was: ' . $mode . ')' );
	}
	
	/**
	 * test the application name method is correctly implemented
	 * 
	 */
	public function testGetApplicationName() {
		$this->assertTrue ( 'test application' == $this->testObject->getApplicationName (), 'application name incorrectly identified' );
	}
	
	/**
	 * test that the machine which is running this test is a development server (should be)
	 * 
	 */
	public function testThatCurrentMachineIsDevelopment() {
		$this->assertTrue ( $this->testObject->isDevelopmentServer (), 'failed to check that current machine is registered as development server' );
	}
	
	/**
	 * test that the machine which is running this test is a NOT a production server (should be)
	 * 
	 */
	public function testThatCurrentMachineIsNotProduction() {
		$this->assertFalse ( $this->testObject->isProductionServer (), 'failed to check that current machine is not registered as production server' );
	}
	
	/**
	 * also test that a fake server is not listed as development or production
	 * 
	 */
	public function testThatFakeServerIsNotDevelopmentOrProduction() {
		$fakeServer = '123456789abcdefg';
		$this->assertFalse ( $this->testObject->isDevelopmentServer ( $fakeServer ), 'failed to make sure that fake server is correctly identified as NOT development' );
		$this->assertFalse ( $this->testObject->isProductionServer ( $fakeServer ), 'failed to make sure that fake is server is correctly identified as NOT production' );
	}
}

