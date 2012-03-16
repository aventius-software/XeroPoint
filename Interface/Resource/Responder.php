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
	 * implement this method to produce resource output via buffer output (e.g. echo)
	 * 
	 */
	public function output();
}