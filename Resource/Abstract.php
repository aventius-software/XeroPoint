<?php
/**
 * XeroPoint resource abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Resource_Abstract {
	
	/**
	 * URL parameter to set the name/identifier of the requested resource
	 * 
	 * @var string
	 */
	const REQUEST_IDENTIFIER = 'xpRequestIdentifier';
	
	/**
	 * URL parameter to set the type of resource being requested
	 * 
	 * @var string
	 */
	const REQUEST_TYPE = 'xpRequestType';
	
	/**
	 * holds the resource name
	 * 
	 * @var string
	 */
	protected $resourceName;
	
	/**
	 * holds the resource type
	 * 
	 * @var string
	 */
	protected $resourceType;
	
	/**
	 * URL separator by default is ampersand character
	 * 
	 * @var string
	 */
	protected $separator = '&';
	
	/**
	 * holds all the URL parameters
	 * 
	 * @var array
	 */
	protected $urlParameters = array ();
	
	/**
	 * set the resource name
	 * 
	 * @param string $resourceName
	 */
	public function __construct($resourceName) {
		// must always set resource name
		$this->resourceName = $resourceName;
		
		// split class to get resource type
		$classParts = explode ( '_', get_class ( $this ) );
		$this->resourceType = array_pop ( $classParts );
	}
	
	/**
	 * add 1 or more parameters (in key => value pairs) to the URL
	 * 
	 * @param array $urlParameters
	 * @return XeroPoint_Resource_Abstract
	 */
	public function addURLParameters(array $urlParameters) {
		$this->urlParameters = array_merge ( $this->urlParameters, $urlParameters );
		return $this;
	}
	
	/**
	 * returns this resource name
	 * 
	 * @return string
	 */
	public function getResourceName() {
		return $this->resourceName;
	}
	
	/**
	 * get the current URL parameter separator for this resource type
	 * 
	 * @return string
	 */
	public function getSeparator() {
		return $this->separator;
	}
	
	/**
	 * generate this resources request URL
	 * 
	 * @param bool $parametersOnly
	 * @return string
	 */
	public function getURL($parametersOnly = false) {
		// reset a string variable to store the new URL
		$requestURL = '';
		$additionalURLParameters = '';
		
		// build any extra url parameters
		if (count ( $this->urlParameters ) > 0) {
			// start with the current URL parameter separator
			$additionalURLParameters = $this->getSeparator ();
			
			// cycle through each additional parameter and append to the string
			foreach ( $this->urlParameters as $parameter => $value ) {
				$additionalURLParameters .= $parameter . '=' . $value;
			}
		}
		
		// if running on web server...
		if (isset ( $_SERVER ['SERVER_NAME'] )) {
			// must have resource type specified
			if ($this->resourceType && $this->resourceName) {
				// work out the protocol and port
				$protocol = strtolower ( $_SERVER ['HTTPS'] ) == 'on' ? 'https://' : 'http://';
				$port = $_SERVER ['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER ['SERVER_PORT'];
				
				// build request URL
				$requestURL = $protocol . $_SERVER ['SERVER_NAME'] . $port . $_SERVER ['SCRIPT_NAME'] . 'index.php?';
				$requestURL .= self::REQUEST_IDENTIFIER . '=' . $this->resourceName;
				$requestURL .= $this->separator . self::REQUEST_TYPE . '=' . $this->resourceType;
			} else {
				throw new Exception ( 'resource URL can only be generated when a resource name and type have been set' );
			}
		}
		
		return $requestURL . $additionalURLParameters;
	}
	
	/**
	 * set the URL parameter separator character
	 * 
	 * @param string $separator
	 * @return XeroPoint_Resource_Abstract
	 */
	protected function setSeparator($separator) {
		$this->separator = $separator;
		return $this;
	}
}