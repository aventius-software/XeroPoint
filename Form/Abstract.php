<?php
/**
 * XeroPoint form abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Form_Abstract {
	
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
	 * flag to indicate if this form has been processed
	 * 
	 * @var bool
	 */
	protected $processed = false;
	
	/**
	 * holds a unique identifier for a hidden form control to track the form
	 * 
	 * @var string
	 */
	protected $trackingID;
	
	/**
	 * used for tracking the form
	 * 
	 * @var string
	 */
	protected $trackingValue = 0;
	
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
		if (class_exists ( 'PHPUnit_Framework_TestCase', false )) {
			self::$forms = array ();
		}
		
		// is this a duplicate form?
		if (in_array ( $id, self::$forms )) {
			throw new Exception ( 'this form is already defined elsewhere in this script' );
		}
		
		// set the name of this form
		$this->id = $id;
		$this->trackingID = $id . '_xpID' . rand ( 10000, 99999 );
		
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
		if ($this->processed) {
			throw new Exception ( 'form controls cannot be added after the form has been processed' );
		}
		
		if (key_exists ( $control->getID (), $this->controls )) {
			throw new Exception ( 'a control with the ID: ' . $control->getID () . ', has already been added to this form!' );
		} else {
			$this->controls [$control->getID ()] = $control;
		}
		
		return $this;
	}
	
	/**
	 * return the current action URL
	 * 
	 * @return string
	 */
	public function getActionURL() {
		$protocol = isset ( $_SERVER ['HTTPS'] ) && strtolower ( $_SERVER ['HTTPS'] ) == 'on' ? 'https://' : 'http://';
		$server = isset ( $_SERVER ['SERVER_NAME'] ) ? $_SERVER ['SERVER_NAME'] : '';
		$script = $_SERVER ['SCRIPT_NAME'];
		$qs = $_SERVER ['QUERY_STRING'] == '' ? '' : '?' . str_replace ( '&', '&amp;', $_SERVER ['QUERY_STRING'] );
		
		return $protocol . $server . $script . $qs;
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
		return '<form id="' . $this->id . '" action="' . $this->getActionURL () . '">';
	}
	
	/**
	 * return the complete html for this form
	 * 
	 * @return string
	 */
	public function getHtml() {
		if (! $this->processed) {
			throw new Exception ( 'this form must be processed before any html can be generated' );
		}
		
		$body = '<p><input id="' . $this->trackingID . '" type="hidden" value="' . $this->trackingValue . '"/></p>';
		
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
	 * returns the ID of the tracking control
	 * 
	 * @return string
	 */
	public function getTrackingID() {
		return $this->trackingID;
	}
	
	/**
	 * returns bool to indicate if this form has been submitted and its fields are in the post
	 * note that this does not apply to checkbox fields as these are not set in the post if unchecked!
	 *
	 * @return bool
	 */
	public function hasSubmittedData() {
		return $this->method == self::METHOD_POST ? isset ( $_POST [$this->trackingID] ) : isset ( $_GET [$this->trackingID] );
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
	 * this method processes the form, checks its rules and calls any control validation
	 * 
	 * @return XeroPoint_Form_Abstract
	 */
	public function process() {
		$this->onLoad ();
		
		$this->processed = true;
		$this->trackingValue = 1;
		
		return $this;
	}
	
	/**
	 * remove all controls currently attached to this form
	 * 
	 * @return XeroPoint_Form_Abstract
	 */
	public function removeAllControls() {
		$this->controls = array ();
		return $this;
	}
	
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