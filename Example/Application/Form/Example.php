<?php
/**
 * XeroPoint example form
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Application_Form_Example extends XeroPoint_Form_Abstract {
	
	/**
	 * this method is called if any of the form controls fail validation or if a form rule is broken
	 * 
	 */
	public function onFailure() {
		// no action yet
	}
	
	/**
	 * this method is always called to initialise the form
	 * 
	 */
	public function onLoad() {
		// create a simple textbox
		$textbox = new XeroPoint_Control_TextBox ( 'I_am_a_textbox' );
		$textbox->setLabel ( 'type something' );
		$textbox->prependHtml ( '<span>BEFORE</span>' );
		$textbox->appendHtml ( '<span>AFTER</span>' );
		
		// add a test textbox
		$this->addControl ( $textbox );
	}
	
	/**
	 * this method is called on successful validation of any form controls and the verification of any form rules
	 * 
	 */
	public function onSuccess() {
		// no action yet
	}
}