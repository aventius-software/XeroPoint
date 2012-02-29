<?php
/**
 * XeroPoint configuration abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Configuration_Abstract {
	
	/**
	 * list of development servers
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
	 * returns the current mode as string
	 * 
	 * @return string
	 */
	public function getMode() {
		return array_pop ( explode ( '_', get_class ( $this ) ) );
	}
	
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
			$serverName = 'localhost';
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
			$serverName = 'localhost';
		}
		
		return array_key_exists ( $serverName, $this->productionServerList );
	}
	
	/**
	 * register a server that is used for development
	 * note that 'localhost' is specified already by default
	 * 
	 * @param string $serverName
	 */
	public function registerDevelopmentServer($serverName) {
		$this->developmentServerList [$serverName] = true;
	}
	
	/**
	 * register a server for production mode
	 * 
	 * @param string $serverName
	 */
	public function registerProductionServer($serverName) {
		$this->productionServerList [$serverName] = true;
	}
}