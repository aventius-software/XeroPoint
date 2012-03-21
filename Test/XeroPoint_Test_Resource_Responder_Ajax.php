<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Resource_Responder_Ajax_Unit_Test extends XeroPoint_Resource_Responder_Ajax_Abstract {
	
	const TEST_MESSAGE = 'test response';
	
	public function buildResponse() {
		echo self::TEST_MESSAGE;
	}
}

class XeroPoint_Test_Resource_Responder_Ajax extends PHPUnit_Framework_TestCase {
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Resource_Responder_Ajax_Abstract
	 */
	private $testObject;
	
	/**
	 * used to test URL parameters
	 * 
	 * @var array
	 */
	private $testURLParameters = array ( 
		'param' => 'value' 
	);
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new XeroPoint_Resource_Responder_Ajax_Unit_Test ();
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
	 * test that the main build response method correctly outputs the desired string
	 * 
	 */
	public function testBuildResponse() {
		// start buffering to capture response
		ob_start ();
		echo $this->testObject->buildResponse ();
		$response = ob_get_clean ();
		
		// output response for simple debugging/viewing
		echo "\nBUILD RESPONSE:\n$response\n";
		
		// test
		$this->assertTrue ( XeroPoint_Resource_Responder_Ajax_Unit_Test::TEST_MESSAGE == $response );
	}
	
	/**
	 * tests the send response method returns the correct string
	 * 
	 */
	public function testSendResponse() {
		// capture response - note the parameter of 'true' to indicate testing
		$response = $this->testObject->sendResponse ( true );
		
		// output to debug
		echo "\nSEND RESPONSE:\n$response\n";
		
		// and test...
		$this->assertTrue ( XeroPoint_Resource_Responder_Ajax_Unit_Test::TEST_MESSAGE == $response );
	}
}

