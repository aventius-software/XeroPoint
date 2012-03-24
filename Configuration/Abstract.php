<?php
/**
 * XeroPoint configuration abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Configuration_Abstract {
	
	/**
	 * list of development servers - localhost by default is in this list
	 * 
	 * @var array
	 */
	protected $developmentServerList = array ( 
		'localhost' => true 
	);
	
	/**
	 * list of production servers
	 * 
	 * @var array
	 */
	protected $productionServerList = array ();
	
	/**
	 * holds the name of the server
	 * 
	 * @var string
	 */
	protected $serverName = 'localhost';
	
	/**
	 * create new configuration and optionally set the default server name
	 * 
	 * @param string $serverName
	 */
	public function __construct($serverName = 'localhost') {
		$this->serverName = isset ( $_SERVER ['SERVER_NAME'] ) ? $_SERVER ['SERVER_NAME'] : $serverName;
	}
	
	/**
	 * returns the current mode as string
	 * 
	 * @return string
	 */
	public function getMode() {
		$parts = explode ( '_', get_class ( $this ) );
		return array_pop ( $parts );
	}
	
	/**
	 * implement this to return the current application title
	 * 
	 * @return string
	 */
	abstract public function getApplicationName();
	
	/**
	 * returns true if the specified server is a development server
	 * optional first parameter to specify server name otherwise defaults
	 * to the current server
	 * 
	 * @param string $serverName
	 * @return bool
	 */
	public function isDevelopmentServer($serverName = null) {
		if (is_null ( $serverName )) {
			$serverName = $this->serverName;
		}
		
		return array_key_exists ( $serverName, $this->developmentServerList );
	}
	
	/**
	 * returns true if the specified server is a production server
	 * optional first parameter to specify server name otherwise defaults
	 * to the current server
	 * 
	 * @param string $serverName
	 * @return bool
	 */
	public function isProductionServer($serverName = null) {
		if (is_null ( $serverName )) {
			$serverName = $this->serverName;
		}
		
		return array_key_exists ( $serverName, $this->productionServerList );
	}
	
	/**
	 * register a server that is used for development
	 * note that 'localhost' is specified already by default
	 * 
	 * @param string $serverName
	 * @return XeroPoint_Configuration_Abstract
	 */
	public function registerDevelopmentServer($serverName) {
		$this->developmentServerList [$serverName] = true;
		return $this;
	}
	
	/**
	 * register a server for production mode
	 * 
	 * @param string $serverName
	 * @return XeroPoint_Configuration_Abstract
	 */
	public function registerProductionServer($serverName) {
		$this->productionServerList [$serverName] = true;
		return $this;
	}
}