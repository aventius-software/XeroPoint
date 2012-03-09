<?php
/**
 * XeroPoint Ajax resource class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Resource_Ajax extends XeroPoint_Resource_Abstract {
	
	public function __toString() {
		return $this->getURL ();
	}
}