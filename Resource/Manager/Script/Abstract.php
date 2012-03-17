<?php
/**
 * XeroPoint script resource class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

abstract class XeroPoint_Resource_Manager_Script_Abstract extends XeroPoint_Resource_Manager_Abstract {
	
	public function __construct() {
		parent::__construct ();
		$this->separator = '&amp;';
	}
}