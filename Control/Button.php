<?php
/**
 * XeroPoint button control
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

class XeroPoint_Control_Button extends XeroPoint_Control_Abstract {
	
	/**
	 * holds the type of button
	 * 
	 * @var string
	 */
	protected $buttonType = 'button';
	
	/**
	 * create new button
	 * 
	 * @param string $id
	 * @param string $method
	 */
	public function __construct($id, $method = self::METHOD_POST) {
		parent::__construct ( $id, $method );
		$this->hideLabel ();
	}
	
	/**
	 * returns the html code for this control
	 * 
	 * @return string
	 */
	protected function getControlHtml() {
		return '<button id="' . $this->id . '" type="' . $this->buttonType . '">' . htmlentities ( $this->label ) . '</button>';
	}
}