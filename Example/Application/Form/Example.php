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
		
		// create a fieldset
		$fieldset = new XeroPoint_Form_FieldSet ( 'I_am_a_fieldset' );
		$fieldset->setLegend ( 'I am a legend' );
		
		// and a submit button
		$submit = new XeroPoint_Control_Submit ( 'I_am_a_submit_button' );
		$submit->setLabel ( 'click me' );
		
		// add to the fieldset
		$fieldset->addControl ( $submit );
		
		// add fieldset to the form
		$this->addFieldSet ( $fieldset );
	}
	
	/**
	 * this method is called on successful validation of any form controls and the verification of any form rules
	 * 
	 */
	public function onSuccess() {
		// no action yet
	}
}