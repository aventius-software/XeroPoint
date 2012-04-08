<?php
require_once 'PHPUnit\Framework\TestCase.php';
require_once 'XeroPoint.php';

class XeroPoint_Test_Form_FieldSet extends PHPUnit_Framework_TestCase {
	
	/**
	 * test ID of the fieldset
	 * 
	 * @var string
	 */
	const TEST_FIELDSET_ID = 'test_form_fieldset';
	
	/**
	 * test object
	 * 
	 * @var XeroPoint_Form_FieldSet
	 */
	private $testObject;
	
	/**
	 * Prepares the environment before running a test.
	 * 
	 */
	protected function setUp() {
		parent::setUp ();
		$this->testObject = new XeroPoint_Form_FieldSet ( self::TEST_FIELDSET_ID );
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
	 * tests that the ID of the fieldset is returned correctly
	 * 
	 */
	public function testGetID() {
		$this->assertTrue ( self::TEST_FIELDSET_ID == $this->testObject->getID (), 'fieldset ID incorrectly returned' );
	}
	
	/**
	 * tests the lower fieldset comment can be set/retrieved correctly
	 * 
	 */
	public function testFooterComment() {
		$this->assertTrue ( '123' == $this->testObject->setFooterComment ( '123' )->getFooterComment (), 'incorrect lower fieldset comment' );
	}
	
	/**
	 * tests the upper fieldset comment can be set/retrieved correctly
	 * 
	 */
	public function testHeaderComment() {
		$this->assertTrue ( '321' == $this->testObject->setHeaderComment ( '321' )->getHeaderComment (), 'incorrect upper fieldset comment' );
	}
	
	/**
	 * tests for expected fieldset html output
	 * 
	 */
	public function testGetHtml() {
		$expected = '<fieldset id="' . self::TEST_FIELDSET_ID . '"><p>header</p><p>footer</p></fieldset>';
		$actual = $this->testObject->setHeaderComment ( '<p>header</p>' )->setFooterComment ( '<p>footer</p>' )->getHtml ();
		
		echo "\nFIELDSET HTML WITHOUT CONTROLS (EXPECTED):-\n$expected\n\n(ACTUAL):\n$actual\n";
		
		$this->assertTrue ( $expected == $actual, 'incorrect fieldset html returned' );
	}
	
	/**
	 * tests that the fieldset can add/retrieve controls
	 * 
	 */
	public function testAddControl() {
		$this->testObject->addControl ( new XeroPoint_Control_TextBox ( 'add' ) );
		$this->assertTrue ( $this->testObject->getControlByID ( 'add' ) instanceof XeroPoint_Control_TextBox, 'incorrect form control type returned' );
	}
	
	/**
	 * tests that we can remove controls from the fieldset
	 * 
	 */
	public function testRemoveControl() {
		$this->testObject->addControl ( new XeroPoint_Control_TextBox ( 'remove' ) )->removeControl ( 'remove' );
		$this->assertTrue ( $this->testObject->getControlByID ( 'remove' ) === null, 'incorrect form control type returned' );
	}
	
	/**
	 * tests the html output of the fieldset with a control attached to it
	 * 
	 */
	public function testGetHtmlWithControl() {
		$this->testObject->removeAllControls ();
		
		$expected = '<fieldset id="' . self::TEST_FIELDSET_ID . '"><p id="test_container"><input id="test" type="text" maxlength="255" value=""/></p></fieldset>';
		$actual = $this->testObject->addControl ( new XeroPoint_Control_TextBox ( 'test' ) )->getHtml ();
		
		echo "\nFIELDSET HTML OUTPUT WITH CONTROL (EXPECTED):-\n$expected\n\n(ACTUAL)\n$actual\n";
		
		$this->assertTrue ( $expected == $actual, 'incorrect fieldset html' );
	}
	
	/**
	 * tests the html output of the fieldset with a control attached to it and a legend
	 * 
	 */
	public function testGetHtmlWithControlAndLegend() {
		$this->testObject->removeAllControls ()->setLegend ( 'I am legend' );
		
		$expected = '<fieldset id="' . self::TEST_FIELDSET_ID . '"><legend>I am legend</legend><p id="test_container"><input id="test" type="text" maxlength="255" value=""/></p></fieldset>';
		$actual = $this->testObject->addControl ( new XeroPoint_Control_TextBox ( 'test' ) )->getHtml ();
		
		echo "\nFIELDSET HTML OUTPUT WITH CONTROL (EXPECTED):-\n$expected\n\n(ACTUAL)\n$actual\n";
		
		$this->assertTrue ( $expected == $actual, 'incorrect fieldset html' );
	}
}