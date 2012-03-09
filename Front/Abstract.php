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
	 * @TODO implement this!
	 */
	public function catchResourceRequests() {
		if (false) {
			echo 'resource request captured';
			exit ();
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