<?php
/**
 * XeroPoint validator abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Validator_Abstract {
	
	/**
	 * holds a list of error messages
	 * 
	 * @var array
	 */
	protected $errorMessages = array ();
	
	/**
	 * add an error message to the list
	 * 
	 * @param string $message
	 */
	protected function addErrorMessage($message) {
		$this->errorMessages [] = $message;
	}
	
	/**
	 * clear the current list of error messages
	 * 
	 */
	protected function clearErrorMessages() {
		$this->errorMessages = array ();
	}
	
	/**
	 * get the current error messages
	 * 
	 * @return array
	 */
	public function getErrorMessages() {
		return $this->errorMessages;
	}
	
	/**
	 * returns bool depending on validation success or failure
	 * 
	 * @param mixed $value
	 * @return bool
	 */
	abstract public function test($value);
}