<?php
/**
 * XeroPoint style resource class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Resource_Style extends XeroPoint_Resource_Abstract {
	
	public function __construct($resourceName) {
		parent::__construct ( $resourceName );
		$this->separator = '&amp;';
	}
}