<?php
/**
 * XeroPoint front controller/router abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Front_Abstract {
	
	/**
	 * current application configuration
	 * 
	 * @var XeroPoint_Configuration_Abstract
	 */
	protected $configuration;
	
	/**
	 * stores the name of the page parameter
	 * 
	 * @var string
	 */
	private $pageParameterName = 'page';
	
	/**
	 * this method must be implemented and you must set the configuration
	 * 
	 */
	abstract public function __construct();
	
	/**
	 * this method is called before main to capture any resource requests
	 * note that the application is terminated if any request is found and processed
	 * 
	 * optional parameter to return the resource object - if a resource was captured
	 * 
	 * @param bool $returnResourceObject
	 * @return mixed
	 */
	public function catchResourceRequests($returnResourceObject = false) {
		// get the request settings
		$name = isset ( $_GET [XeroPoint_Resource_Abstract::REQUEST_IDENTIFIER] ) ? $_GET [XeroPoint_Resource_Abstract::REQUEST_IDENTIFIER] : null;
		$type = isset ( $_GET [XeroPoint_Resource_Abstract::REQUEST_TYPE] ) ? $_GET [XeroPoint_Resource_Abstract::REQUEST_TYPE] : null;
		$serverBased = isset ( $_GET [XeroPoint_Resource_Abstract::REQUEST_MODE] ) ? '' : 'Application_';
		$resource = null;
		
		// is there a resource request and if so are the correct parameters set?
		if (ctype_alpha ( str_replace ( '_', '', $name ) ) && ctype_alpha ( $type )) {
			// define the class
			$class = 'XeroPoint_' . $serverBased . 'Resource_Responder_' . $type . '_' . $name;
			
			// try and call the class static method
			if (in_array ( 'XeroPoint_Interface_Resource_Responder', class_implements ( $class ) )) {
				// call the resource handler
				try {
					// call our handler
					$resource = new $class ();
					$resource->sendClientResponse ( true, true );
				} catch ( Exception $e ) {
					// output error
					echo 'Resource request error, could not execute ZeroPoint resource handler (' . $class . ')';
				}
			} else {
				// class does not exist
				echo 'Handler for resource: ' . $name . ', cannot be not found, please check paths and that the resource handler exists on the server';
			}
			
			// always exit after processing a resource - for good measure!
			if ($returnResourceObject) {
				return $resource;
			} else {
				exit ();
			}
		}
	}
	
	/**
	 * returns the current configuration being used by the application
	 * 
	 * @return XeroPoint_Configuration_Abstract
	 */
	public function getConfiguration() {
		return $this->configuration;
	}
	
	/**
	 * get the current page - if no page is currently active
	 * then this method returns null
	 * 
	 * @return string
	 */
	public function getPage() {
		return isset ( $_GET [$this->pageParameterName] ) ? $_GET [$this->pageParameterName] : null;
	}
	
	/**
	 * get the current string that is used to specify the page in URL's
	 * 
	 * @return string
	 */
	public function getPageParameterName() {
		return $this->pageParameterName;
	}
	
	/**
	 * you must implement this method which is only called when
	 * running an application - note that this method is not called if 
	 * a resource request is received
	 * 
	 * @return void
	 */
	abstract public function main();
	
	/**
	 * pass flow to a specific controller and collect buffer output
	 * 
	 * @param XeroPoint_Controller_Abstract $controller
	 * @return string
	 */
	public function runController(XeroPoint_Controller_Abstract $controller) {
		// start buffering so we can capture the output
		ob_start ();
		
		// execute the controller and capture any output response
		$controller->main ( $this );
		
		// and send back to the caller
		return ob_get_clean ();
	}
	
	/**
	 * set the current application configuration
	 * 
	 * @param XeroPoint_Configuration_Abstract $configuration
	 * @return XeroPoint_Front_Abstract
	 */
	public function setConfiguration(XeroPoint_Configuration_Abstract $configuration) {
		$this->configuration = $configuration;
		return $this;
	}
	
	/**
	 * set the current page parameter name to be used in URL's
	 * 
	 * @param string $parameterName
	 * @return XeroPoint_Front_Abstract
	 */
	protected function setPageParameterName($parameterName) {
		$this->pageParameterName = $parameterName;
		return $this;
	}
}