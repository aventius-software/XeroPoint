<?php
/**
 * XeroPoint JQuery script resource class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Resource_Manager_Script_JQuery extends XeroPoint_Resource_Manager_Script_Abstract {
	
	/**
	 * flag to indicate if the JQueryUI resource has been loaded already
	 * @var unknown_type
	 */
	private static $alreadyImportedJQueryUI = false;
	
	/**
	 * import the JQueryUI library into this JQuery script resource as a single linked resource
	 * 
	 * @return XeroPoint_Resource_Manager_Script_JQuery
	 */
	public function importUI() {
		// only import if not already loaded
		if (! self::$alreadyImportedJQueryUI) {
			// add the import flag to the URL
			$this->addURLParameters ( array ( 
				'importJQueryUI' => 'yes' 
			) );
			
			// set the class flag so we will not import it again
			self::$alreadyImportedJQueryUI = true;
		}
	}
}