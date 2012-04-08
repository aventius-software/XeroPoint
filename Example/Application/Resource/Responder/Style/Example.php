<?php
/**
 * XeroPoint example CSS style resource responder
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Application_Resource_Responder_Style_Example extends XeroPoint_Resource_Responder_Style_Abstract {
	
	/**
	 * output CSS response
	 * 
	 */
	public function buildResponse() {
		echo 'body { color:blue; }';
	}
}