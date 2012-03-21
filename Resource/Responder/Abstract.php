<?php
/**
 * XeroPoint abstract resource responder class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

abstract class XeroPoint_Resource_Responder_Abstract {
	
	/**
	 * use caching by default
	 * 
	 * @var bool
	 */
	protected $useCaching = true;
	
	/**
	 * use GZIP by default
	 * 
	 * @var bool
	 */
	protected $useGZIP = true;
	
	/**
	 * must override this method to output (e.g. echo) your response
	 * 
	 */
	abstract public function buildResponse();
	
	/**
	 * implement this method and send correct content type header and return the pre-processed response
	 * 
	 * @param string $response
	 * @return string
	 */
	protected function preProcessResponse($response) {
		return $response;
	}
	
	/**
	 * returns the complete output including headers to the client
	 * 
	 * @param bool $testing
	 * @return mixed
	 */
	public function sendResponse($testing = false) {
		// start buffer capture
		ob_start ();
		
		// now output all code
		$this->buildResponse ();
		
		// pre-process the response first
		$buffer = $this->preProcessResponse ( ob_get_clean () );
		
		// when testing ignore any headers or further buffering
		if ($testing) {
			return $buffer;
		}
		
		// using caching?
		if ($this->useCaching) {
			header ( 'Cache-Control: max-age=2592000, public' );
			header ( 'Expires-Active: On' );
			header ( 'Expires: Fri, 1 Jan 2500 01:01:01 GMT' );
			header ( 'Pragma:' );
		}
		
		// using GZIP?
		if ($this->useGZIP) {
			// yes so send the correct header
			header ( 'Content-Encoding: gzip' );
			
			// and start a gzip buffer
			if (! ob_start ( 'ob_gzhandler' )) {
				echo 'resource buffering error';
			}
		} else {
			// normal buffering
			ob_start ();
		}
		
		// send code
		echo $buffer;
		
		// send all to client
		ob_flush ();
	}
}