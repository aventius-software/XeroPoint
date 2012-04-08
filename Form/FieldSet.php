<?php
/**
 * XeroPoint form fieldset class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

class XeroPoint_Form_FieldSet {
	
	/**
	 * holds this fieldsets controls
	 * 
	 * @var array
	 */
	protected $controls = array ();
	
	/**
	 * comment string/html for the lower part of the fieldset
	 * 
	 * @var string
	 */
	protected $footerComment = '';
	
	/**
	 * comment string/html for the upper part of the fieldset
	 * 
	 * @var string
	 */
	protected $headerComment = '';
	
	/**
	 * holds the ID of this fieldset
	 * 
	 * @var string
	 */
	protected $id;
	
	/**
	 * holds the legend text for this fieldset
	 * 
	 * @var string
	 */
	protected $legend = '';
	
	/**
	 * create a new form fieldset
	 * 
	 * @param string $id
	 * @param string $legend
	 */
	public function __construct($id, $legend = '') {
		$this->id = $id;
		$this->legend = $legend;
	}
	
	/**
	 * add a control to the fieldset
	 * 
	 * @param XeroPoint_Control_Abstract $control
	 * @return XeroPoint_Form_FieldSet
	 */
	public function addControl(XeroPoint_Control_Abstract $control) {
		if (key_exists ( $control->getID (), $this->controls )) {
			throw new Exception ( 'this control is already attached to this fieldset' );
		} else {
			$this->controls [$control->getID ()] = $control;
		}
		
		return $this;
	}
	
	/**
	 * returns the specified control if it exists
	 * 
	 * @param string $id
	 * @return XeroPoint_Control_Abstract
	 */
	public function getControlByID($id = null) {
		if (isset ( $this->controls [$id] )) {
			return $this->controls [$id];
		} else {
			return null;
		}
	}
	
	/**
	 * returns all controls attached to this fieldset
	 * 
	 * @return array
	 */
	public function getControls() {
		return $this->controls;
	}
	
	/**
	 * returns the lower fieldset comment string
	 * 
	 * @return string
	 */
	public function getFooterComment() {
		return $this->footerComment;
	}
	
	/**
	 * returns the upper fieldset comment string
	 * 
	 * @return string
	 */
	public function getHeaderComment() {
		return $this->headerComment;
	}
	
	/**
	 * returns the complete html for this fieldset and any attached controls
	 * 
	 * @return string
	 */
	public function getHtml() {
		// start the fieldset html code
		$html = '<fieldset id="' . $this->id . '">';
		
		// have we got a legend?
		$html .= $this->legend == '' ? '' : '<legend>' . htmlentities ( $this->legend ) . '</legend>';
		
		// any header comments?
		$html .= $this->headerComment == '' ? '' : $this->headerComment;
		
		// get any attached controls
		foreach ( $this->controls as $control ) {
			/* @var $control XeroPoint_Control_Abstract */
			$html .= $control->getHtml ();
		}
		
		// any footer comments?
		$html .= $this->footerComment == '' ? '' : $this->footerComment;
		
		// close the and return the completed html fieldset
		return $html . '</fieldset>';
	}
	
	/**
	 * returns the ID of this fieldset
	 * 
	 * @return string
	 */
	public function getID() {
		return $this->id;
	}
	
	/**
	 * returns the legend of the fieldset if set otherwise a blank string
	 * 
	 * @return string
	 */
	public function getLegend() {
		return $this->legend;
	}
	
	/**
	 * remove all controls currently attached to this fieldset
	 * 
	 * @return XeroPoint_Form_FieldSet
	 */
	public function removeAllControls() {
		$this->controls = array ();
		return $this;
	}
	
	/**
	 * removes specified control from the fieldset
	 * 
	 * @param string $id
	 * @return XeroPoint_Form_FieldSet
	 */
	public function removeControl($id) {
		unset ( $this->controls [$id] );
		return $this;
	}
	
	/**
	 * set the lower fieldset comment
	 * 
	 * @param string $footerComment
	 * @return XeroPoint_Form_FieldSet
	 */
	public function setFooterComment($footerComment) {
		$this->footerComment = $footerComment;
		return $this;
	}
	
	/**
	 * set the upper fieldset comment
	 * 
	 * @param string $headerComment
	 * @return XeroPoint_Form_FieldSet
	 */
	public function setHeaderComment($headerComment) {
		$this->headerComment = $headerComment;
		return $this;
	}
	
	/**
	 * set the legend for this fieldset
	 * 
	 * @param string $legend
	 * @return XeroPoint_Form_FieldSet
	 */
	public function setLegend($legend) {
		$this->legend = $legend;
		return $this;
	}
}