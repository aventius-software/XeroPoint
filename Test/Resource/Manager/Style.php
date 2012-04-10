<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Resource_Manager_Style_Unit_Test extends XeroPoint_Resource_Manager_Style_Abstract {

}

class XeroPoint_Test_Resource_Manager_Style extends PHPUnit_Framework_TestCase {
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Resource_Manager_Style_Unit_Test
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
		$this->testObject = new XeroPoint_Resource_Manager_Style_Unit_Test ();
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
	 * tests that the URL parameter separator for style URL strings is '&amp;'
	 * 
	 */
	public function testGetSeparator() {
		$this->assertTrue ( '&amp;' == $this->testObject->getSeparator () );
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
		$testURL = 'http://test/index.php?xpRequestIdentifier=Unit_Test&amp;xpRequestType=Style&amp;xpRequestMode=1';
		
		// first check URL root is ok
		$this->assertTrue ( $testURL == $this->testObject->getURL (), 'incorrect URL: ' . $this->testObject->getURL () );
		
		// add some parameters
		$this->testObject->resetParameters ()->addURLParameters ( $this->testURLParameters );
		
		// now check again
		$this->assertTrue ( $testURL . '&amp;param=value' == $this->testObject->getURL (), 'incorrect URL and parameters: ' . $this->testObject->getURL () );
	}
	
	/**
	 * test that the style resource manager recognises external URL has been specified and returns it via getURL method
	 * 
	 */
	public function testGetURLWithExternalURL() {
		$this->testObject->setExternalURL ( 'http://externalurl/resource.css' );
		$this->assertTrue ( 'http://externalurl/resource.css' == $this->testObject->getURL (), 'incorrect url returned when using external link' );
	}
}