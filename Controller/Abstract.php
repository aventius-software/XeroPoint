<?php
/**
 * XeroPoint controller abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Controller_Abstract {
	
	/**
	 * controller entry point
	 * 
	 * @param XeroPoint_Front_Abstract $front
	 */
	abstract public function main(XeroPoint_Front_Abstract $front);
}