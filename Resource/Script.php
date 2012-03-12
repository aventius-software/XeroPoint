<?php
/**
 * XeroPoint script resource class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Resource_Script extends XeroPoint_Resource_Abstract {
	
	public function __construct($resourceName) {
		parent::__construct ( $resourceName );
		$this->separator = '&amp;';
	}
}