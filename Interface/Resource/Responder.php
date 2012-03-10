<?php
/**
 * XeroPoint resource response interface
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

interface XeroPoint_Interface_Resource_Responder {
	
	/**
	 * must implement this method to allow client response
	 * 
	 * @param bool $useCaching
	 * @param bool $useGZIP
	 */
	public function sendClientResponse($useCaching = true, $useGZIP = true);
	
	/**
	 * produce resource output
	 * 
	 */
	abstract protected function output();
}