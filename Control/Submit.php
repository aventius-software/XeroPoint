<?php
/**
 * XeroPoint submit control
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

class XeroPoint_Control_Submit extends XeroPoint_Control_Button {
	
	/**
	 * create new submit button
	 * 
	 * @param string $id
	 * @param string $method
	 */
	public function __construct($id, $method = self::METHOD_POST) {
		parent::__construct ( $id, $method );
		$this->buttonType = 'submit';
	}
}