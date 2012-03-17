<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Resource_Manager_Ajax_Unit_Test extends XeroPoint_Resource_Manager_Ajax_Abstract {

}

class XeroPoint_Test_Resource_Manager_Ajax extends PHPUnit_Framework_TestCase {
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Resource_Ajax
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
		$this->testObject = new XeroPoint_Resource_Manager_Ajax_Unit_Test ();
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
	 * tests output of the __toString method
	 * 
	 */
	public function test__ToString() {
		$this->testObject->addURLParameters ( $this->testURLParameters );
		$this->assertTrue ( '&param=value' === ( string ) $this->testObject, 'failed to get correct URL from __toString method: ' . ( string ) $this->testObject );
	}
	
	/**
	 * tests that the URL parameters that are set by addURLParameters are correctly returned by getURL(true) method
	 * 
	 */
	public function testAddURLParameters() {
		$this->testObject->addURLParameters ( $this->testURLParameters );
		$this->assertTrue ( 'param=value' === $this->testObject->getURL ( true ), 'failed to get correct URL parameters: ' . $this->testObject->getURL ( true ) );
	}
	
	/**
	 * tests that the URL parameter separator for Ajax URL strings is '&'
	 * 
	 */
	public function testGetSeparator() {
		$this->assertTrue ( '&' == $this->testObject->getSeparator () );
	}
	
	/**
	 * tests that getURL method returns a correctly formatted URL
	 * 
	 */
	public function testGetURL() {
		// fake server name and port
		$_SERVER ['SERVER_NAME'] = 'test';
		$_SERVER ['SERVER_PORT'] = 80;
		$_SERVER ['HTTPS'] = 'off';
		$_SERVER ['SCRIPT_NAME'] = '/';
		
		// this is URL format we want
		$testURL = 'http://test/index.php?xpRequestIdentifier=Unit_Test&xpRequestType=Ajax&xpRequestMode=1';
		
		// output for debugging
		echo "\n\nURL SHOULD BE:\n$testURL";
		
		// now get the URL from the test object
		$returnedURL = $this->testObject->getURL ();
		
		// output for debugging
		echo "\n\nRETURNED URL IS:\n$returnedURL";
		
		// first check URL root is ok
		$this->assertTrue ( $testURL == $returnedURL, 'incorrect URL: ' . $returnedURL );
		
		// add some parameters
		$this->testObject->resetParameters ()->addURLParameters ( $this->testURLParameters );
		
		// now check again
		$this->assertTrue ( $testURL . '&param=value' == $this->testObject->getURL (), 'incorrect URL and parameters: ' . $this->testObject->getURL () );
	}
}

