<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class Document_HTML_Test_Class extends XeroPoint_Document_HTML {

}

class XeroPoint_Test_Document_HTML extends PHPUnit_Framework_TestCase {
	
	const TEST_CSS_URI = 'http://testcss';
	const TEST_SCRIPT_URI = 'http://testscript';
	const TEST_TAG = '<div>test</div>';
	const TEST_TITLE = 'test title';
	
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
		$this->testObject->addLinkedCSS ( self::TEST_CSS_URI );
		$this->assertTrue ( self::TEST_CSS_URI == array_pop ( $this->testObject->getLinkedCSS () ) );
	}
	
	public function testAddScript() {
		$this->testObject->addLinkedScript ( self::TEST_SCRIPT_URI );
		$this->assertTrue ( self::TEST_SCRIPT_URI == array_pop ( $this->testObject->getLinkedScripts () ) );
	}
	
	public function testSetTitle() {
		$this->testObject->setTitle ( self::TEST_TITLE );
		$this->assertTrue ( self::TEST_TITLE == $this->testObject->getTitle () );
	}
	
	public function testGetHtml() {
		$this->testObject->setTitle ( self::TEST_TITLE )->addBodyHtml ( self::TEST_TAG )->addLinkedCSS ( self::TEST_CSS_URI )->addLinkedScript ( self::TEST_SCRIPT_URI );
		
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
		$this->testObject->setTitle ( self::TEST_TITLE )->addBodyHtml ( self::TEST_TAG )->addLinkedCSS ( self::TEST_CSS_URI )->addLinkedScript ( self::TEST_SCRIPT_URI );
		
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

