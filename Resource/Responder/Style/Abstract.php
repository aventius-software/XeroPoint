<?php
/**
 * XeroPoint style resource responder class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

abstract class XeroPoint_Resource_Responder_Style_Abstract extends XeroPoint_Resource_Responder_Abstract {
	
	/**
	 * override the default pre-process method to parse the CSS response and send correct content type header
	 * 
	 * @param string $response
	 * @return string
	 */
	protected function preProcessResponse($response) {
		// remove any style tags if present
		$response = str_replace ( array ( 
			'<style>', 
			'</style>' 
		), array ( 
			'', 
			'' 
		), $response );
		
		// remember to send the correct content type header! helps!
		if (! $this->testing) {
			header ( 'Content-Type: text/css' );
		}
		
		// return processed response
		return $response;
	}
}