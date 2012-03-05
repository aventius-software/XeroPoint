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
		// pass to controller for something
		echo $this->runController ( new XeroPoint_Application_Controller_Default () );
		
		// access the XeroPoint sub system
		$xeroPoint = new XeroPoint ();
		
		// now handle any duties
		echo 'application ready (processed in: ' . $xeroPoint->getApplicationStartTime ( true ) . ')';
	}
}