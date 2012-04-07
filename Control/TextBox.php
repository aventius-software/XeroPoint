<?php
/**
 * XeroPoint textbox control
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

class XeroPoint_Control_TextBox extends XeroPoint_Control_Abstract {
	
	/**
	 * returns the html code for this control
	 * 
	 * @return string
	 */
	protected function getControlHtml() {
		return '<input id="' . $this->id . '" type="text"/>';
	}
}