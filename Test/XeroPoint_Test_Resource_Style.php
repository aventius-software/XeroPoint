<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Test_Resource_Style extends PHPUnit_Framework_TestCase {
	
	const TEST_RESOURCE_NAME = 'test_resource';
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Resource_Style
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
		$this->testObject = new XeroPoint_Resource_Style ( self::TEST_RESOURCE_NAME );
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
	 * tests that the resource name is returned correctly
	 * 
	 */
	public function testGetResourceName() {
		$this->assertTrue ( self::TEST_RESOURCE_NAME == $this->testObject->getResourceName (), 'failed to get correct resource name: ' . $this->testObject->getResourceName () );
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
		$testURL = 'http://test/index.php?xpRequestIdentifier=' . self::TEST_RESOURCE_NAME . '&amp;xpRequestType=Style&amp;xpRequestMode=1';
		
		// first check URL root is ok
		$this->assertTrue ( $testURL == $this->testObject->getURL (), 'incorrect URL: ' . $this->testObject->getURL () );
		
		// add some parameters
		$this->testObject->resetParameters ()->addURLParameters ( $this->testURLParameters );
		
		// now check again
		$this->assertTrue ( $testURL . '&amp;param=value' == $this->testObject->getURL (), 'incorrect URL and parameters: ' . $this->testObject->getURL () );
	}
}

