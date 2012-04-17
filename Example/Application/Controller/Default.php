<?php
/**
 * XeroPoint example default controller
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Application_Controller_Default extends XeroPoint_Controller_Abstract {
	
	/**
	 * create the default controller and add example CSS resource
	 * 
	 * @param XeroPoint_Document_HTML $document
	 */
	public function __construct(XeroPoint_Document_HTML $document) {
		// add a local resource using the resource management mechanism
		$document->addResource ( new XeroPoint_Application_Resource_Manager_Style_Example () );
		
		// add an external CSS for whatever reason
		$document->addScript ( 'http://ajax.googleapis.com/ajax/libs/dojo/1.7.1/dojo/dojo.js' );
		
		// add CSS - doesn't matter that they are added after scripts, the document will always build with CSS links before scripts!
		$document->addCSS ( 'http://ajax.googleapis.com/ajax/libs/dojo/1.7.1/dijit/themes/claro/claro.css' );
		
		// add a XeroPoint library based resource manager (in this case the JQuery library)
		$document->addResource ( new XeroPoint_Resource_Manager_Script_JQuery () );
	}
	
	/**
	 * controller entry point
	 * 
	 * @param XeroPoint_Front_Abstract $front
	 */
	public function main(XeroPoint_Front_Abstract $front) {
		// create an example form
		$form = new XeroPoint_Application_Form_Example ( 'example_form' );
		$form->process ();
		
		// output some html
		echo '<div>this is the default controller speaking...</div>' . $form->getHtml ();
	}
}