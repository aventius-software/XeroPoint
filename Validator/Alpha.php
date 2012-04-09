<?php
/**
 * XeroPoint alphabetical string validator class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

class XeroPoint_Validator_Alpha extends XeroPoint_Validator_Abstract {
	
	/**
	 * returns bool depending on success or failure of alphabetical string validation
	 * 
	 * @param string $value
	 * @return bool
	 */
	public function test($value) {
		if (preg_match ( "/^[a-zA-Z]+$/", $value )) {
			return true;
		} else {
			$this->addErrorMessage ( 'this is not a valid alphabetical string' );
			return false;
		}
	}
}