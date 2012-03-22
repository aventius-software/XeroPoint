<?php
/**
 * XeroPoint script resource responder class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

abstract class XeroPoint_Resource_Responder_Script_Abstract extends XeroPoint_Resource_Responder_Abstract {
	
	/**
	 * override the default pre-process method to parse the script response and send correct content type header
	 * 
	 * @param string $response
	 * @return string
	 */
	protected function preProcessResponse($response) {
		// remove any tags if present
		$response = str_replace ( array ( 
			'<script type="text/javascript">', 
			'</script>' 
		), array ( 
			'', 
			'' 
		), $response );
		
		// remember to send the correct content type header! helps!
		if (! $this->testing) {
			header ( 'Content-Type: text/javascript' );
		}
		
		// return processed response
		return $response;
	}
}