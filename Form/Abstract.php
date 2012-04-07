<?php
/**
 * XeroPoint form abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Form_Abstract {
	
	/**
	 * holds all the controls attached to this form
	 * 
	 * @var array
	 */
	protected $controls = array ();
	
	/**
	 * holds the ID's of all declared forms in a single script
	 * 
	 * @var array
	 */
	protected static $forms = array ();
	
	/**
	 * comment string/html for the lower part of the form
	 * 
	 * @var string
	 */
	protected $footerComment = '';
	
	/**
	 * comment string/html for the upper part of the form
	 * 
	 * @var string
	 */
	protected $headerComment = '';
	
	/**
	 * the ID of this form
	 * 
	 * @var string
	 */
	protected $id;
	
	/**
	 * holds the method of the form POST/GET
	 * 
	 * @var string
	 */
	protected $method;
	
	/**
	 * GET method
	 * 
	 * @var string
	 */
	const METHOD_GET = 'get';
	
	/**
	 * POST method
	 * 
	 * @var string
	 */
	const METHOD_POST = 'post';
	
	/**
	 * create a new form
	 * 
	 * @param string $id
	 * @param string $method
	 */
	public function __construct($id, $method = self::METHOD_POST) {
		// must specify a form name!
		if (empty ( $id )) {
			throw new Exception ( 'no form id has been specified' );
		}
		
		// when performing tests reset the cache!
		if (class_exists ( 'PHPUnit_Framework_TestCase' )) {
			self::$forms = array ();
		}
		
		// is this a duplicate form?
		if (in_array ( $id, self::$forms )) {
			throw new Exception ( 'this form is already defined elsewhere in this script' );
		}
		
		// set the name of this form
		$this->id = $id;
		
		// and the method
		$this->method = $method;
		
		// save this form
		self::$forms [$id] = $id;
	}
	
	/**
	 * add a control to the form
	 * 
	 * @param XeroPoint_Control_Abstract $control
	 * @return XeroPoint_Form_Abstract
	 */
	public function addControl(XeroPoint_Control_Abstract $control) {
		if (key_exists ( $control->getID (), $this->controls )) {
			throw new Exception ( 'a control with the ID: ' . $control->getID () . ', has already been added to this form!' );
		} else {
			$this->controls [$control->getID ()] = $control;
		}
		
		return $this;
	}
	
	/**
	 * returns the requested control if it exists otherwise null
	 * 
	 * @param string $id
	 * @return XeroPoint_Control_Abstract
	 */
	public function getControlByID($id) {
		return isset ( $this->controls [$id] ) ? $this->controls [$id] : null;
	}
	
	/**
	 * returns the lower form comment string
	 * 
	 * @return string
	 */
	public function getFooterComment() {
		return $this->footerComment;
	}
	
	/**
	 * returns the footer html for the form
	 * 
	 * @return string
	 */
	public function getFooterHtml() {
		return '</form>';
	}
	
	/**
	 * returns the upper form comment string
	 * 
	 * @return string
	 */
	public function getHeaderComment() {
		return $this->headerComment;
	}
	
	/**
	 * returns the header html for the form
	 * 
	 * @return string
	 */
	public function getHeaderHtml() {
		return '<form>';
	}
	
	/**
	 * return the complete html for this form
	 * 
	 * @return string
	 */
	public function getHtml() {
		$body = '';
		
		foreach ( $this->controls as $id => $control ) {
			/* @var $control XeroPoint_Control_Abstract */
			$body .= $control->getHtml ();
		}
		
		return $this->getHeaderHtml () . $this->getHeaderComment () . $body . $this->getFooterComment () . $this->getFooterHtml ();
	}
	
	/**
	 * returns the ID of this form
	 * 
	 * @return string
	 */
	public function getID() {
		return $this->id;
	}
	
	/**
	 * returns the method of this form
	 * 
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}
	
	/**
	 * method to handle failures
	 * 
	 */
	abstract public function onFailure();
	
	/**
	 * method called everytime and best placed for initialising any form elements etc..
	 * 
	 */
	abstract public function onLoad();
	
	/**
	 * called when all elements (if any) have been validated correctly
	 * 
	 */
	abstract public function onSuccess();
	
	/**
	 * removes specified control from the form
	 * 
	 * @param string $id
	 * @return XeroPoint_Form_Abstract
	 */
	public function removeControl($id) {
		unset ( $this->controls [$id] );
		return $this;
	}
	
	/**
	 * set the lower form comment
	 * 
	 * @param string $footerComment
	 * @return XeroPoint_Form_Abstract
	 */
	public function setFooterComment($footerComment) {
		$this->footerComment = $footerComment;
		return $this;
	}
	
	/**
	 * set the upper form comment
	 * 
	 * @param string $headerComment
	 * @return XeroPoint_Form_Abstract
	 */
	public function setHeaderComment($headerComment) {
		$this->headerComment = $headerComment;
		return $this;
	}
}