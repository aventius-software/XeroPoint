<?php
/**
 * XeroPoint ajax resource responder class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

abstract class XeroPoint_Resource_Responder_Ajax_Abstract extends XeroPoint_Resource_Responder_Abstract {
	
	/**
	 * create new ajax resource responder
	 * 
	 * this turns off caching for ajax responses
	 * also note that ajax responses are GZIPPED unless
	 * specified otherwise!
	 * 
	 */
	public function __construct() {
		$this->useCaching = false;
	}
}