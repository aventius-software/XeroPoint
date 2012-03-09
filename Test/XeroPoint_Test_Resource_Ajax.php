<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Test_Resource_Ajax extends PHPUnit_Framework_TestCase {
	
	const TEST_RESOURCE_NAME = 'test_resource';
	
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
		$this->testObject = new XeroPoint_Resource_Ajax ( self::TEST_RESOURCE_NAME );
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
	
	public function testAddURLParameters() {
		$this->testObject->addURLParameters ( $this->testURLParameters );
		$this->assertTrue ( '&param=value' === $this->testObject->getURL ( true ), 'failed to get correct URL parameters: ' . $this->testObject->getURL ( true ) );
	}
	
	/**
	 * tests that the URL parameter separator for Ajax URL strings is '&'
	 * 
	 */
	public function testGetSeparator() {
		$this->assertTrue ( '&' == $this->testObject->getSeparator () );
	}
}

