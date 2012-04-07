<?php
/**
 * XeroPoint example application front controller
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Application_Front_Controller extends XeroPoint_Front_Abstract {
	
	/**
	 * create new front controller and initialise a boot configuration
	 * 
	 */
	public function __construct() {
		// you must set a configuration here
		$this->setConfiguration ( new XeroPoint_Application_Configuration_Default () );
	}
	
	/**
	 * handle normal application requests
	 * 
	 */
	public function main() {
		// create a document/layout to work with
		$document = new XeroPoint_Document_HTML ();
		$document->setTitle ( $this->getConfiguration ()->getApplicationName () );
		
		// pass to controller for something and get any html returned by the controller
		$document->addBodyHtml ( $this->runController ( new XeroPoint_Application_Controller_Default ( $document ) ) );
		
		// access the XeroPoint sub system
		$xeroPoint = new XeroPoint ();
		
		// now handle any duties
		$document->addBodyHtml ( '<div>application ready (processed in: ' . $xeroPoint->getApplicationStartTime ( true ) . ')</div>' );
		
		// output to client
		echo $document;
	}
}