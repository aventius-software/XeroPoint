<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Resource_Manager_Script_DocumentUnitTest extends XeroPoint_Resource_Manager_Script_Abstract {

}

class XeroPoint_Resource_Manager_Style_DocumentUnitTest extends XeroPoint_Resource_Manager_Style_Abstract {

}

class Document_HTML_Test_Class extends XeroPoint_Document_HTML {

}

class XeroPoint_Test_Document_HTML extends PHPUnit_Framework_TestCase {
	
	const TEST_CSS_RESOURCE_NAME = 'Test';
	const TEST_CSS_URL = 'http://testcss';
	const TEST_SCRIPT_RESOURCE_NAME = 'Test';
	const TEST_SCRIPT_URL = 'http://testscript';
	const TEST_TAG = '<div>test</div>';
	const TEST_TITLE = 'test title';
	const TEST_WORD_WRAP = 80;
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Document_HTML
	 */
	private $testObject;
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new Document_HTML_Test_Class ();
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
	
	public function testAddBodyHtml() {
		$this->testObject->addBodyHtml ( self::TEST_TAG );
		$this->assertTrue ( self::TEST_TAG == $this->testObject->getBodyHtml () );
	}
	
	public function testAddCSS() {
		$this->testObject->addCSS ( self::TEST_CSS_URL );
		$css = $this->testObject->getCSS ();
		$this->assertTrue ( self::TEST_CSS_URL == array_pop ( $css ) );
	}
	
	public function testAddResource() {
		// add a CSS resource first
		$this->testObject->addResource ( new XeroPoint_Resource_Manager_Style_DocumentUnitTest () );
		
		// fake server name and port
		$_SERVER ['SERVER_NAME'] = 'test';
		$_SERVER ['SERVER_PORT'] = 80;
		$_SERVER ['HTTPS'] = 'off';
		$_SERVER ['SCRIPT_NAME'] = '/';
		
		// this is URL format we want
		$urlCSS = 'http://test/index.php?xpRequestIdentifier=DocumentUnitTest&amp;xpRequestType=Style&amp;xpRequestMode=1';
		
		// build the html we are looking for in the response
		$html = '';
		$html .= '<title></title>';
		$html .= '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
		$html .= '<link href="' . $urlCSS . '" type="text/css" rel="stylesheet"/>';
		
		// output for debugging purposes if anything goes wrong
		echo "\n\n\n*** HEAD HTML WITH ONLY CSS RESOURCE ***";
		echo "\n\nSHOULD BE:\n" . wordwrap ( $html, self::TEST_WORD_WRAP );
		echo "\n\nACTUAL IS:\n" . wordwrap ( $this->testObject->getHeadHtml (), self::TEST_WORD_WRAP );
		
		// test...
		$this->assertTrue ( $html == $this->testObject->getHeadHtml (), 'incorrect head html returned: ' . $this->testObject->getHeadHtml () );
		
		// now check script resources
		$this->testObject->addResource ( new XeroPoint_Resource_Manager_Script_DocumentUnitTest () );
		
		// fake server name and port
		$_SERVER ['SERVER_NAME'] = 'test';
		$_SERVER ['SERVER_PORT'] = 80;
		$_SERVER ['HTTPS'] = 'off';
		$_SERVER ['SCRIPT_NAME'] = '/';
		
		// this is URL format we want
		$urlScript = 'http://test/index.php?xpRequestIdentifier=DocumentUnitTest&amp;xpRequestType=Script&amp;xpRequestMode=1';
		
		// again build the html that the head method should return
		$html = '';
		$html .= '<title></title>';
		$html .= '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
		$html .= '<link href="' . $urlCSS . '" type="text/css" rel="stylesheet"/>';
		$html .= '<script href="' . $urlScript . '" type="text/javascript"/>';
		
		// output for debugging purposes
		echo "\n\n\n*** HEAD HTML WITH CSS AND SCRIPT RESOURCES ***";
		echo "\n\nSHOULD BE:\n" . wordwrap ( $html, self::TEST_WORD_WRAP );
		echo "\n\nACTUAL IS:\n" . wordwrap ( $this->testObject->getHeadHtml (), self::TEST_WORD_WRAP );
		
		// and test again...
		$this->assertTrue ( $html == $this->testObject->getHeadHtml (), 'incorrect head html returned' );
	}
	
	public function testAddScript() {
		$this->testObject->addScript ( self::TEST_SCRIPT_URL );
		$scripts = $this->testObject->getScripts ();
		$this->assertTrue ( self::TEST_SCRIPT_URL == array_pop ( $scripts ) );
	}
	
	public function testSetTitle() {
		$this->testObject->setTitle ( self::TEST_TITLE );
		$this->assertTrue ( self::TEST_TITLE == $this->testObject->getTitle () );
	}
	
	public function testGetHtml() {
		$this->testObject->setTitle ( self::TEST_TITLE )->addBodyHtml ( self::TEST_TAG )->addCSS ( self::TEST_CSS_URL )->addScript ( self::TEST_SCRIPT_URL );
		
		$html = '';
		$html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$html .= '<html xmlns="http://www.w3.org/1999/xhtml">';
		$html .= '<head>';
		$html .= '<title>' . self::TEST_TITLE . '</title>';
		$html .= '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
		$html .= '</head>';
		$html .= '<body>' . self::TEST_TAG . '</body>';
		$html .= '</html>';
		
		$this->assertTrue ( $html == $this->testObject->getHtml () );
	}
	
	public function test__toString() {
		$this->testObject->setTitle ( self::TEST_TITLE )->addBodyHtml ( self::TEST_TAG )->addCSS ( self::TEST_CSS_URL )->addScript ( self::TEST_SCRIPT_URL );
		
		$html = '';
		$html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$html .= '<html xmlns="http://www.w3.org/1999/xhtml">';
		$html .= '<head>';
		$html .= '<title>' . self::TEST_TITLE . '</title>';
		$html .= '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';
		$html .= '</head>';
		$html .= '<body>' . self::TEST_TAG . '</body>';
		$html .= '</html>';
		
		$this->assertTrue ( $html == ( string ) $this->testObject );
	}
}

