<?php
/**
 * XeroPoint document HTML class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Document_HTML {
	
	/**
	 * html5 doctype
	 * 
	 * at this time (March 2012) html5 is partially supported by some 
	 * browsers but it is not a recommended specification as yet by W3C
	 * 
	 * @var string
	 */
	const DOCTYPE_HTML5 = '<!DOCTYPE html>';
	
	/**
	 * strict xhtml1.0 doctype
	 * 
	 * at this time most browsers support xhtml1.0 at least when served 
	 * as text/html instead of an xml content type
	 * 
	 * @var string
	 */
	const DOCTYPE_STRICT = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	
	/**
	 * holds the body of html for the document
	 * 
	 * @var string
	 */
	protected $body = '';
	
	/**
	 * holds the doctype for this document
	 * 
	 * @var string
	 */
	private $doctype;
	
	/**
	 * entries for the header tag
	 * 
	 * @var array
	 */
	protected $head = array ();
	
	/**
	 * will hold the html opening tag string for this document
	 * 
	 * @var string
	 */
	private $htmlOpenTag;
	
	/**
	 * holds any linked CSS 
	 * 
	 * @var array
	 */
	protected $linkedCSS = array ();
	
	/**
	 * holds any linked scripts
	 * 
	 * @var array
	 */
	protected $linkedScripts = array ();
	
	/**
	 * holds the resources for this document
	 * 
	 * @var array
	 */
	protected $resources = array ();
	
	/**
	 * holds the document title
	 * 
	 * @var string
	 */
	protected $title;
	
	/**
	 * create a new document
	 * 
	 * @param string $doctype
	 */
	public function __construct($doctype = self::DOCTYPE_STRICT) {
		$this->doctype = $doctype;
		
		switch ($this->doctype) {
			case self::DOCTYPE_HTML5 :
				$this->htmlOpenTag = '<html lang="en">';
				break;
			
			case self::DOCTYPE_STRICT :
				$this->htmlOpenTag = '<html xmlns="http://www.w3.org/1999/xhtml">';
				break;
			
			default :
				throw new Exception ( 'invalid doctype supplied for the html document object' );
				break;
		}
	}
	
	/**
	 * alias for getHtml()
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this->getHtml ();
	}
	
	/**
	 * add string to the current html body
	 * 
	 * @param string $html
	 * @return XeroPoint_Document_HTML
	 */
	public function addBodyHtml($html) {
		$this->body .= $html;
		return $this;
	}
	
	/**
	 * add a CSS link to the document
	 * 
	 * @param string $url
	 * @return XeroPoint_Document_HTML
	 */
	public function addCSS($url) {
		$this->linkedCSS [$url] = $url;
		return $this;
	}
	
	/**
	 * add a XeroPoint resource to the document
	 * 
	 * @param XeroPoint_Resource_Manager_Abstract $resource
	 * @return XeroPoint_Document_HTML
	 */
	public function addResource(XeroPoint_Resource_Manager_Abstract $resource) {
		$this->resources [get_class ( $resource )] = $resource;
		return $this;
	}
	
	/**
	 * add a script link to the document
	 * 
	 * @param string $url
	 * @return XeroPoint_Document_HTML
	 */
	public function addScript($url) {
		$this->linkedScripts [$url] = $url;
		return $this;
	}
	
	/**
	 * helper method that returns a link tag for placing in the head
	 * 
	 * @param string $cssURI
	 * @param string $type
	 * @param string $rel
	 * @return string
	 */
	protected function buildLinkTag($url, $type = 'text/css', $rel = 'stylesheet') {
		return '<link type="' . $type . '" rel="' . $rel . '" href="' . $url . '" />';
	}
	
	/**
	 * helper method that returns a script tag for placing in the head
	 * 
	 * @param string $url
	 * @param string $type
	 * @return string
	 */
	protected function buildScriptTag($url, $type = 'text/javascript') {
		return '<script type="' . $type . '" src="' . $url . '" ></script>';
	}
	
	/**
	 * return the current html of the document body
	 * 
	 * @return string
	 */
	public function getBodyHtml() {
		return $this->body;
	}
	
	/**
	 * return the current list of linked CSS URI's
	 * 
	 * @return array
	 */
	public function getCSS() {
		return $this->linkedCSS;
	}
	
	/**
	 * return the current html for the document head
	 * 
	 * @return string
	 */
	public function getHeadHtml() {
		// create html for resources
		$resources = '';
		
		// now add any fixed URL CSS resources
		foreach ( $this->linkedCSS as $cssURL ) {
			$resources .= $this->buildLinkTag ( $cssURL );
		}
		
		// now add any fixed URL script resources
		foreach ( $this->linkedScripts as $scriptURL ) {
			$resources .= $this->buildScriptTag ( $scriptURL );
		}
		
		// attach resources
		foreach ( $this->resources as $resource ) {
			/* @var $resource XeroPoint_Resource_Abstract */
			if ($resource instanceof XeroPoint_Resource_Manager_Style_Abstract) {
				$resources .= $this->buildLinkTag ( $resource->getURL () );
			} else if ($resource instanceof XeroPoint_Resource_Manager_Script_Abstract) {
				$resources .= $this->buildScriptTag ( $resource->getURL () );
			} else {
				throw new Exception ( 'invalid resource type of: ' . get_class ( $resource ) . ', has been added to document' );
			}
		}
		
		// return the title and the encoding for the document
		return '<title>' . $this->title . '</title><meta http-equiv="content-type" content="text/html;charset=utf-8"/>' . $resources . implode ( '', $this->head );
	}
	
	/**
	 * return the complete html output for this document
	 * 
	 * @return string
	 */
	public function getHtml() {
		// add the header tag
		$html = '<head>' . $this->getHeadHtml () . '</head>';
		
		// and the main body
		$html .= '<body>' . $this->body . '</body>';
		
		// now return the complete document
		return $this->doctype . $this->htmlOpenTag . $html . '</html>';
	}
	
	/**
	 * returns the current resources assigned to this document
	 * 
	 * @return array
	 */
	public function getResources() {
		return $this->resources;
	}
	
	/**
	 * return the current list of linked script URI's
	 * 
	 * @return array
	 */
	public function getScripts() {
		return $this->linkedScripts;
	}
	
	/**
	 * return the current document title
	 * 
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * set the html for the document body
	 * 
	 * @param string $html
	 * @return XeroPoint_Document_HTML
	 */
	public function setBodyHtml($html) {
		$this->body = $html;
		return $this;
	}
	
	/**
	 * set the title of the document
	 * 
	 * @param string $title
	 * @return XeroPoint_Document_HTML
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
}