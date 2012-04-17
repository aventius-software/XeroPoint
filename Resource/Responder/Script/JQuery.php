<?php
/**
 * XeroPoint script resource responder class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Resource_Responder_Script_JQuery extends XeroPoint_Resource_Responder_Script_Abstract {
	
	/**
	 * remote location of JQuery library either http or local filesystem
	 * 
	 * @var string
	 */
	protected $coreURL = 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js';
	
	/**
	 * respond with the JQuery (and optionally if specified, the JQueryUI) library
	 * 
	 */
	public function buildResponse() {
		echo file_get_contents ( $this->coreURL );
	}
}