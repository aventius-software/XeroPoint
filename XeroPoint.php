<?php
/**
 * XeroPoint framework
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

class XeroPoint {
	
	const APPLICATION_PATH = 'XEROPOINT_APPLICATION_PATH';
	const PUBLIC_PATH = 'XEROPOINT_PUBLIC_PATH';
	
	/**
	 * holds the currently running application
	 * 
	 * @var XeroPoint_Front_Abstract
	 */
	private static $application;
	
	/**
	 * holds the path to the current applications 'application' (or private) path
	 * 
	 * @var string
	 */
	private static $applicationPath;
	
	/**
	 * holds the start time of the current running XeroPoint application
	 * 
	 * @var int
	 */
	private static $applicationStartTime;
	
	/**
	 * flag to indicate if the XeroPoint system is initialised or not
	 * 
	 * @var bool
	 */
	private static $initialised = false;
	
	/**
	 * holds the path which is the current applications publically visible path
	 * 
	 * @var string
	 */
	private static $publicPath;
	
	/**
	 * holds the path to the XeroPoint directory
	 * 
	 * @var string
	 */
	private static $root;
	
	/**
	 * create the XeroPoint system control object
	 * 
	 */
	public function __construct() {
		// if not already initialised...
		if (! self::$initialised) {
			// record start
			self::$applicationStartTime = microtime ( true );
			
			// fix some ini settings first
			ini_set ( 'session.use_trans_sid', false );
			
			// get the directory that XeroPoint is running under
			self::$root = dirname ( __FILE__ );
			
			// if we are running an application pick up the values of the public path and application folder name
			self::$publicPath = defined ( self::PUBLIC_PATH ) ? constant ( self::PUBLIC_PATH ) : str_replace ( '\\', '/', realpath ( '.' ) );
			self::$applicationPath = defined ( self::APPLICATION_PATH ) ? constant ( self::APPLICATION_PATH ) : str_replace ( '\\', '/', realpath ( self::$publicPath . '/../Application' ) );
			
			// set the root path
			self::$root = str_replace ( '\\', '/', realpath ( dirname ( __FILE__ ) ) );
			
			// now register our class autoloader
			spl_autoload_register ( array ( 
				$this, 
				'autoloader' 
			) );
			
			// and flag the system as initialised...
			self::$initialised = true;
		}
	}
	
	/**
	 * internal method to act as autoloader
	 * 
	 * @param string $resource
	 */
	private function autoloader($resource) {
		// if already loaded then don't bother
		if (class_exists ( $resource )) {
			return;
		}
		
		// only allow letters and underscores
		if (! ctype_alpha ( str_replace ( '_', '', $resource ) )) {
			throw new Exception ( 'XeroPoint class/interface autoload problem, invalid resource name - only letters and/or underscores are permitted' );
		}
		
		// have we been initialised yet?
		if (is_null ( self::$root )) {
			throw new Exception ( 'the XeroPoint system has not been initialised, please initialise before attempting to load a class/interface' );
		}
		
		// XeroPoint or Application based?
		if (substr ( $resource, 0, strlen ( 'XeroPoint_Application' ) ) == 'XeroPoint_Application') {
			$root = self::$applicationPath;
			$path = str_replace ( 'XeroPoint_Application', '', $resource );
		} else {
			$root = self::$root;
			$path = '/' . str_replace ( 'XeroPoint_', '', $resource );
		}
		
		// find the file
		$file = $root . str_replace ( '_', '/', $path ) . '.php';
		
		// does it exist
		if (file_exists ( $file )) {
			// include the code as normal
			require $file;
		} else {
			// indicate fatal error as file does not exist
			throw new Exception ( 'the requested class or interface (' . $resource . ') cannot be found at file location (' . $file . ')' );
		}
	}
	
	/**
	 * returns the current application 'application' path
	 * 
	 * @return string
	 */
	public function getApplicationPath() {
		return self::$applicationPath;
	}
	
	/**
	 * returns start time of processing or 
	 * optionally the current time difference between now and start
	 * 
	 * @param bool $calculateTimeDifference
	 */
	public function getApplicationStartTime($calculateTimeDifference = false) {
		return $calculateTimeDifference ? microtime ( true ) - self::$applicationStartTime : self::$applicationStartTime;
	}
	
	/**
	 * returns the current applications public path
	 * 
	 * @return string
	 */
	public function getPublicPath() {
		return self::$publicPath;
	}
	
	/**
	 * returns the current XeroPoint directory path
	 * 
	 * @return string
	 */
	public function getRoot() {
		return self::$root;
	}
	
	/**
	 * run the XeroPoint system and application
	 * 
	 */
	public function run() {
		// test for running an application...
		if (! class_exists ( 'PHPUnit_Framework_TestCase', false ) && file_exists ( self::$applicationPath . '/Front/Controller.php' )) {
			// always initialise the application
			self::$application = new XeroPoint_Application_Front_Controller ( $this );
			
			// enforce rule to always set a configuration
			if (is_null ( self::$application->getConfiguration () )) {
				throw new Exception ( 'you must set an application configuration in front controller constructor' );
			}
			
			// first capture any resource requests
			self::$application->catchResourceRequests ();
			
			// run the application
			self::$application->main ( $this );
			
			// always finish
			exit ();
		}
	}
}

$application = new XeroPoint ();
$application->run ();