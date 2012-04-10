<?php
/**
 * XeroPoint style resource class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

abstract class XeroPoint_Resource_Manager_Style_Abstract extends XeroPoint_Resource_Manager_Abstract {
	
	/**
	 * create a new CSS style resource manager
	 * 
	 */
	public function __construct() {
		parent::__construct ();
		$this->separator = '&amp;';
	}
	
	/**
	 * override the normal resource manager and force a fixed external URL for the resource link
	 * 
	 * @param string $linkURL
	 * @return XeroPoint_Resource_Manager_Style_Abstract
	 */
	public function setExternalURL($linkURL) {
		$this->externalURL = $linkURL;
		return $this;
	}
}