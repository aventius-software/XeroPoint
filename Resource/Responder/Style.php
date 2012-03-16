<?php
/**
 * XeroPoint style resource responder class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

abstract class XeroPoint_Resource_Responder_Style implements XeroPoint_Interface_Resource_Responder {
	
	/**
	 * returns the complete output including headers to the client
	 * 
	 * @param bool $useCaching
	 * @param bool $useGZIP
	 */
	public function sendClientResponse($useCaching = true, $useGZIP = true) {
		// start buffer capture
		ob_start ();
		
		// now output all code
		$this->output ();
		
		// capture the contents above and remove any <style> tags if present
		$bufferOutput = str_replace ( array ( 
			'<style>', 
			'</style>' 
		), array ( 
			'', 
			'' 
		), ob_get_clean () );
		
		// content type
		header ( 'Content-Type: text/css' );
		
		// using caching?
		if ($useCaching) {
			header ( 'Cache-Control: max-age=2592000, public' );
			header ( 'Expires-Active: On' );
			header ( 'Expires: Fri, 1 Jan 2500 01:01:01 GMT' );
			header ( 'Pragma:' );
		}
		
		// using GZIP?
		if ($useGZIP) {
			header ( 'Content-Encoding: gzip' );
			
			if (! ob_start ( 'ob_gzhandler' )) {
				echo 'resource buffering error';
			}
		} else {
			// normal buffering
			ob_start ();
		}
		
		// send code
		echo $bufferOutput;
		
		// send all to client
		ob_flush ();
	}
	
	/**
	 * must implement this method to output your CSS
	 * 
	 */
	public function output() {
		return;
	}
}