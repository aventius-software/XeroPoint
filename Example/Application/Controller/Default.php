<?php
/**
 * XeroPoint example default controller
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Application_Controller_Default extends XeroPoint_Controller_Abstract {
	
	/**
	 * controller entry point
	 * 
	 * @param XeroPoint_Front_Abstract $front
	 */
	public function main(XeroPoint_Front_Abstract $front) {
		// create an example form
		$form = new XeroPoint_Application_Form_Example ( 'example_form' );
		$form->process ();
		
		// output some html
		echo '<div>this is the default controller speaking...</div>' . $form->getHtml ();
	}
}