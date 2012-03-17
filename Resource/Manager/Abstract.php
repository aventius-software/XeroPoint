<?php
/**
 * XeroPoint resource abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Resource_Manager_Abstract {
	
	/**
	 * URL parameter to set the name/identifier of the requested resource
	 * 
	 * @var string
	 */
	const REQUEST_IDENTIFIER = 'xpRequestIdentifier';
	
	/**
	 * URL parameter to specify that the resource is 
	 * XeroPoint based or local application based
	 * 
	 * @var string
	 */
	const REQUEST_MODE = 'xpRequestMode';
	
	/**
	 * URL parameter to set the type of resource being requested
	 * 
	 * @var string
	 */
	const REQUEST_TYPE = 'xpRequestType';
	
	/**
	 * defines if the resource is local application or XeroPoint based
	 * 
	 * @var bool
	 */
	protected $resourceLocalApplicationBased;
	
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
	 * create new resource manager
	 * 
	 */
	public function __construct() {
		// get the class name
		$thisClass = get_class ( $this );
		
		// split class to get resource type and mode
		$classParts = explode ( '_', $thisClass );
		$this->resourceLocalApplicationBased = $classParts [1] == 'Application';
		$this->resourceType = $this->resourceLocalApplicationBased ? $classParts [4] : $classParts [3];
		
		// must always set resource name
		$this->resourceName = str_replace ( 'XeroPoint_Application_Resource_Manager_', '', $thisClass );
		$this->resourceName = str_replace ( 'XeroPoint_Resource_Manager_', '', $this->resourceName );
		$this->resourceName = str_replace ( $this->resourceType . '_', '', $this->resourceName );
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
			// cycle through each additional parameter and append to the string
			foreach ( $this->urlParameters as $parameter => $value ) {
				$additionalURLParameters .= $this->separator . $parameter . '=' . $value;
			}
		}
		
		// if running on web server...
		if (isset ( $_SERVER ['SERVER_NAME'] ) && ! $parametersOnly) {
			// must have resource type specified
			if ($this->resourceType && $this->resourceName) {
				// work out the protocol and port
				$protocol = strtolower ( $_SERVER ['HTTPS'] ) == 'on' ? 'https://' : 'http://';
				$port = $_SERVER ['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER ['SERVER_PORT'];
				
				// build request URL
				$requestURL = $protocol . $_SERVER ['SERVER_NAME'] . $port . str_replace ( '?', '', str_replace ( 'index.php', '', $_SERVER ['SCRIPT_NAME'] ) ) . 'index.php?';
				$requestURL .= self::REQUEST_IDENTIFIER . '=' . $this->resourceName;
				$requestURL .= $this->separator . self::REQUEST_TYPE . '=' . $this->resourceType;
				
				// when not a local resource...
				if (! $this->resourceLocalApplicationBased) {
					$requestURL .= $this->separator . self::REQUEST_MODE . '=1';
				}
			} else {
				throw new Exception ( 'resource URL can only be generated when a resource name and type have been set' );
			}
		} else {
			// if parameters only and there are some parameters then remove the leading separator character(s)
			if ($parametersOnly && $additionalURLParameters != '') {
				$additionalURLParameters = substr ( $additionalURLParameters, strlen ( $this->separator ), strlen ( $additionalURLParameters ) - strlen ( $this->separator ) );
			}
		}
		
		return $requestURL . $additionalURLParameters;
	}
	
	/**
	 * reset the resources parameters
	 * 
	 * @return XeroPoint_Resource_Abstract
	 */
	public function resetParameters() {
		$this->urlParameters = array ();
		return $this;
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