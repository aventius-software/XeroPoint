<?php
/**
 * XeroPoint ajax resource class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

abstract class XeroPoint_Resource_Manager_Ajax_Abstract extends XeroPoint_Resource_Manager_Abstract {
	
	public function __toString() {
		return $this->getURL ();
	}
}